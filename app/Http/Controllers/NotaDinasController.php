<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\NotaDinas;
use App\Models\NotaDinasItem;
use App\Models\MasterMgng;
use App\Models\MasterPsrt;
use App\Models\PermintaanMgng;
use App\Models\BalasanMgng;
use App\Models\MasterBdngMember;
use App\Models\MasterBdng;
use Carbon\Carbon;


class NotaDinasController extends Controller
{
    public function daftar(Request $req)
{
    Carbon::setLocale('id');

    $data = PermintaanMgng::with(['masterMgng.masterSklh.user', 'balasan', 'notaDinas.masterBdng'])
        ->whereHas('notaDinas') // **Hanya permohonan yang punya nota dinas**
        ->whereHas('masterMgng.masterSklh.user', function ($query) use ($req) {
            if ($req->has('keyword')) {
                $keyword = $req->keyword;
                $query->where('fullname', 'like', "%{$keyword}%")
                    ->orWhere('alamat_sklh', 'like', "%{$keyword}%")
                    ->orWhere('telp_sklh', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%")
                    ->orWhere('no_akreditasi_sklh', 'like', "%{$keyword}%")
                    ->orWhere('nama_narahubung', 'like', "%{$keyword}%");
            }
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    $data2 = MasterPsrt::all();

    return view('pages.nota_dinas.daftar', compact('data', 'data2'));
}


public function proposalselector(Request $request)
{
    $data = PermintaanMgng::with(['masterMgng.masterSklh.user', 'balasan'])
    ->where('status_surat_permintaan', 'terkirim')
    ->whereHas('balasan', function ($q) {
        $q->whereNotNull('scan_surat_balasan');
    })
    ->whereHas('masterMgng.masterSklh.user', function ($query) use ($request) {
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where('fullname', 'like', "%{$keyword}%")
                ->orWhere('alamat_sklh', 'like', "%{$keyword}%")
                ->orWhere('telp_sklh', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%")
                ->orWhere('no_akreditasi_sklh', 'like', "%{$keyword}%")
                ->orWhere('nama_narahubung', 'like', "%{$keyword}%");
        }
    })
    ->orderBy('created_at', 'desc')
    ->paginate(10)
    ->withQueryString();

    // Ambil semua peserta magang
    $data2 = MasterPsrt::all();

    // Ambil data balasan magang
    $data3 = BalasanMgng::all();

    return view('pages.nota_dinas.proposalselector', compact('data', 'data2', 'data3'));
}

public function add($id)
{
    // Ambil permohonan berdasarkan ID
        $rc = PermintaanMgng::findOrFail($id);

        // Ambil daftar peserta magang berdasarkan permohonan
        $rd = MasterPsrt::where('permintaan_mgng_id', $rc->id)->get();

        $bidangOptions = MasterBdng::all();
        
        // Kirim data ke view
        return view('pages.nota_dinas.add', compact('rc', 'rd', 'bidangOptions'));

}

public function save(Request $request, $id)
{
    $request->validate([
        'nomor_nota_dinas' => 'required',
        'tanggal_nota_dinas' => 'required|date',
        'sifat_nota_dinas' => 'required',
        'lampiran_nota_dinas' => 'required',
        'master_bdng_id' =>  'required|exists:master_bdng,id',
    ]);
    
    // Mengambil permohonan berdasarkan ID
    $permohonan = PermintaanMgng::findOrFail($id);

    // Cari atau buat nota dinas berdasarkan master_mgng_id
    $notaDinas = NotaDinas::firstOrNew([
        'master_mgng_id' => $permohonan->master_mgng_id,
    ]);

    // Set atribut nota dinas
    $notaDinas->nomor_nota_dinas = $request->nomor_nota_dinas;
    $notaDinas->tanggal_nota_dinas = $request->tanggal_nota_dinas;
    $notaDinas->sifat_nota_dinas = $request->sifat_nota_dinas;
    $notaDinas->lampiran_nota_dinas = $request->lampiran_nota_dinas;
    $notaDinas->master_bdng_id = $request->master_bdng_id;
    $notaDinas->status_nota_dinas = 'belum';

    // Set relasi foreign key
    $notaDinas->master_mgng_id = $permohonan->master_mgng_id;
    $notaDinas->permintaan_mgng_id = $permohonan->id;

    // Cari pejabat dengan jabatan "Sekretaris" dan set id_bdng_member
    $datamember = MasterBdngMember::where('jabatan_pejabat', 'Sekretaris')->first();
    
    // Cek jika data pejabat ditemukan dan set id_bdng_member
    if ($datamember) {
        $notaDinas->bdng_member_id = $datamember->id;
    }

    // Simpan ke database
    $notaDinas->save();

    // Redirect dengan pesan sukses
    return redirect()->route('nota_dinas.daftar')->with('success', 'Nota Dinas berhasil dibuat!');
}


   public function edit($id)
{
    $notaDinas = NotaDinas::findOrFail($id);
    $bidangOptions = MasterBdng::all();

    // Ambil master_psrt_id dari nota_dinas_item berdasarkan nota_dinas_id
    $masterPsrtIds = \App\Models\NotaDinasItem::where('nota_dinas_id', $notaDinas->id)->pluck('master_psrt_id');

    // Ambil peserta sesuai master_psrt_id yang didapat
    $peserta = MasterPsrt::whereIn('id', $masterPsrtIds)->get();

    return view('pages.nota_dinas.edit', compact('notaDinas', 'bidangOptions', 'peserta'));
}

// Update data nota dinas sekaligus upload file scan nota dinas
public function update(Request $request, $id)
{
    $request->validate([
        'nomor_nota_dinas' => 'required',
        'tanggal_nota_dinas' => 'required|date',
        'sifat_nota_dinas' => 'required',
        'lampiran_nota_dinas' => 'required',
        'master_bdng_id' => 'required|exists:master_bdng,id',
        'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    $notaDinas = NotaDinas::findOrFail($id);

    $notaDinas->nomor_nota_dinas = $request->nomor_nota_dinas;
    $notaDinas->tanggal_nota_dinas = $request->tanggal_nota_dinas;
    $notaDinas->sifat_nota_dinas = $request->sifat_nota_dinas;
    $notaDinas->lampiran_nota_dinas = $request->lampiran_nota_dinas;
    $notaDinas->master_bdng_id = $request->master_bdng_id;
    $notaDinas->status_nota_dinas = 'terkirim';

    // Jika permintaan_mgng_id belum terisi, coba set dari relasi master_mgng_id
    if (empty($notaDinas->permintaan_mgng_id) && $notaDinas->master_mgng_id) {
        $permintaan = PermintaanMgng::where('master_mgng_id', $notaDinas->master_mgng_id)->first();
        if ($permintaan) {
            $notaDinas->permintaan_mgng_id = $permintaan->id;
        }
    }

    if ($request->hasFile('file')) {
        // Hapus file lama jika ada
        if ($notaDinas->scan_nota_dinas && Storage::disk('public')->exists($notaDinas->scan_nota_dinas)) {
            Storage::disk('public')->delete($notaDinas->scan_nota_dinas);
        }

        // Simpan file baru
        $path = $request->file('file')->store('uploads', 'public');
        $notaDinas->scan_nota_dinas = $path;
    }

    $notaDinas->save();

    return redirect()->route('nota_dinas.daftar')->with('success', 'Nota Dinas berhasil diperbarui!');
}


public function addItem($id)
{
    $notaDinas = NotaDinas::findOrFail($id);

    // Dapatkan semua permintaan_mgng_id terkait master_mgng_id dari nota dinas
    $permintaanMgngIds = PermintaanMgng::where('master_mgng_id', $notaDinas->master_mgng_id)->pluck('id');

    // Dapatkan peserta master_psrt yang terkait permintaanMgngIds
    // dan yang BELUM terdaftar di nota_dinas_item untuk nota_dinas ini
    $sudahTerdaftarIds = NotaDinasItem::where('nota_dinas_id', $notaDinas->id)->pluck('master_psrt_id')->toArray();

    $pesertaMaster = MasterPsrt::whereIn('permintaan_mgng_id', $permintaanMgngIds)
                        ->whereNotIn('id', $sudahTerdaftarIds)
                        ->orderBy('nama_peserta')
                        ->get();

    return view('pages.nota_dinas.additem', compact('notaDinas', 'pesertaMaster'));
}

// Simpan peserta yang dipilih ke nota_dinas_item
public function storeItem(Request $request, $id)
{
    $request->validate([
        'master_psrt_ids' => 'required|array',
        'master_psrt_ids.*' => 'exists:master_psrt,id',
    ]);

    $notaDinas = NotaDinas::findOrFail($id);

    foreach ($request->master_psrt_ids as $masterPsrtId) {
        // Cek apakah peserta sudah terdaftar (hindari duplikat)
        $exists = NotaDinasItem::where('nota_dinas_id', $notaDinas->id)
                    ->where('master_psrt_id', $masterPsrtId)
                    ->exists();
        if (!$exists) {
            NotaDinasItem::create([
                'nota_dinas_id' => $notaDinas->id,
                'master_psrt_id' => $masterPsrtId,
            ]);
        }
    }

    return redirect()->route('nota_dinas.edit', ['id' => $notaDinas->id])
        ->with('success', 'Peserta berhasil ditambahkan.');
}
public function cetakPdf($id)
{   
    Carbon::setLocale('id');
    
    $notaDinas = NotaDinas::findOrFail($id);
    
    // Ambil permohonan terkait berdasarkan master_mgng_id
    $permintaan = PermintaanMgng::where('master_mgng_id', $notaDinas->master_mgng_id)->firstOrFail();

    // Ambil peserta yang sudah diassign ke nota dinas lewat nota_dinas_item
    $masterPsrtIds = NotaDinasItem::where('nota_dinas_id', $notaDinas->id)->pluck('master_psrt_id');
    $peserta = MasterPsrt::whereIn('id', $masterPsrtIds)->get();

    // Ambil pejabat langsung berdasarkan bdng_member_id di notaDinas
    $pejabat = null;
    if ($notaDinas->bdng_member_id) {
        $pejabat = MasterBdngMember::find($notaDinas->bdng_member_id);
    }

    // Generate PDF dari view, gunakan alias Pdf sesuai import
    $pdf = Pdf::loadView('pages.nota_dinas.cetaknotadinas', compact('notaDinas', 'permintaan', 'peserta', 'pejabat'));
    
    // Stream PDF (buka di tab baru)
    return $pdf->stream('nota_dinas_' . $notaDinas->nomor_nota_dinas . '.pdf');
}
public function viewPeserta($id)
    {
        // Get participant data by ID
        $data = MasterPsrt::findOrFail($id);

        // Get the related request (permohonan) associated with the participant
        $rc = PermintaanMgng::where('id', $data->permintaan_mgng_id)->first();

        // Pass the data to the view
        return view('pages.nota_dinas.viewpeserta', compact('data', 'rc'));
    }
}
