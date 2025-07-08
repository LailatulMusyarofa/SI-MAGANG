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

class ProposalFinalController extends Controller
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
        ->paginate(10)
        ->withQueryString();


    // Ambil peserta berdasarkan nota_dinas.permintaan_mgng_id, bukan langsung dari permintaan_mgng_id
    $data2 = MasterPsrt::whereIn('permintaan_mgng_id', $data->pluck('id'))->get();

    return view('pages.proposal_final.daftar', compact('data', 'data2'));
}

public function tanggapiProposal($id)
{
    // Ambil permohonan magang berdasarkan ID beserta relasi notaDinas dan masterBdng
    $permohonan = PermintaanMgng::with('notaDinas.masterBdng')->findOrFail($id);

    // Ambil peserta magang terkait permohonan ini
    $peserta = MasterPsrt::where('permintaan_mgng_id', $permohonan->id)->get();

    // Kirim data ke view
    return view('pages.proposal_final.tanggapiproposal', compact('permohonan', 'peserta'));
}


public function penilaian($id)
{
    $rc = MasterPsrt::with('notaDinas.masterBdng')->findOrFail($id);

    $permohonan = $rc->permintaan;  

    $masterBdngId = optional($rc->notaDinas)->master_bdng_id;

    $bdngMembers = [];
    if ($masterBdngId) {
        $bdngMembers = MasterBdngMember::where('id_bdng', $masterBdngId)->orderBy('nama_pejabat')->get();
    }

    return view('pages.proposal_final.penilaian', compact('rc', 'bdngMembers', 'permohonan'));
}


public function simpanPenilaian(Request $request, $id)
{
    $rc = MasterPsrt::findOrFail($id);

    $validated = $request->validate([
        'id_bdng_member' => 'required|exists:master_bdng_member,id',
        'nilai_kehadiran' => 'required|numeric|min:0|max:100',
        'nilai_kerapian' => 'required|numeric|min:0|max:100',
        'nilai_sikap' => 'required|numeric|min:0|max:100',
        'nilai_tanggungjawab' => 'required|numeric|min:0|max:100',
        'nilai_kepatuhan' => 'required|numeric|min:0|max:100',
        'nilai_komunikasi' => 'required|numeric|min:0|max:100',
        'nilai_kerjasama' => 'required|numeric|min:0|max:100',
        'nilai_inisiatif' => 'required|numeric|min:0|max:100',
        'nilai_teknis1' => 'required|numeric|min:0|max:100',
        'nilai_teknis2' => 'required|numeric|min:0|max:100',
        'nilai_teknis3' => 'required|numeric|min:0|max:100',
        'nilai_teknis4' => 'required|numeric|min:0|max:100',
        'catatan' => 'nullable|string',
    ]);

    $rc->id_bdng_member = $validated['id_bdng_member'];
    $rc->nilai_kehadiran = $validated['nilai_kehadiran'];
    $rc->nilai_kerapian = $validated['nilai_kerapian'];
    $rc->nilai_sikap = $validated['nilai_sikap'];
    $rc->nilai_tanggungjawab = $validated['nilai_tanggungjawab'];
    $rc->nilai_kepatuhan = $validated['nilai_kepatuhan'];
    $rc->nilai_komunikasi = $validated['nilai_komunikasi'];
    $rc->nilai_kerjasama = $validated['nilai_kerjasama'];
    $rc->nilai_inisiatif = $validated['nilai_inisiatif'];
    $rc->nilai_teknis1 = $validated['nilai_teknis1'];
    $rc->nilai_teknis2 = $validated['nilai_teknis2'];
    $rc->nilai_teknis3 = $validated['nilai_teknis3'];
    $rc->nilai_teknis4 = $validated['nilai_teknis4'];
    $rc->catatan = $validated['catatan'];
    $rc->status_penilaian = 'sudah';
    
    $rc->nilai_akhir = (
        $rc->nilai_kehadiran * 0.0667 +
        $rc->nilai_kerapian * 0.0667 +
        $rc->nilai_sikap * 0.1 +
        $rc->nilai_tanggungjawab * 0.0667 +
        $rc->nilai_kepatuhan * 0.0667 +  
        $rc->nilai_komunikasi * 0.0667 +
        $rc->nilai_kerjasama * 0.0667 +
        $rc->nilai_inisiatif * 0.0667 +
        $rc->nilai_teknis1 * 0.1 +
        $rc->nilai_teknis2 * 0.1 +
        $rc->nilai_teknis3 * 0.1 +
        $rc->nilai_teknis4 * 0.1
    );

    $rc->save();

    return redirect()->route('proposal_final.tanggapi', ['id' => $rc->permintaan_mgng_id])
        ->with('success', 'Penilaian berhasil disimpan');
}

 public function uploadPenilaianForm($id)
    {
        $rc = MasterPsrt::findOrFail($id);

        $permohonan = $rc->permintaan;

        return view('pages.proposal_final.uploadpenilaian', compact('rc', 'permohonan'));
    }

    // Proses simpan file upload penilaian
    public function simpanUploadPenilaian(Request $request, $id)
{
    $rc = MasterPsrt::findOrFail($id);

    $request->validate([
         'scan_penilaian' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // max 10MB
    ]);

    if ($request->hasFile('scan_penilaian')) {
        // Hapus file lama jika ada
        if ($rc->scan_penilaian) {
            Storage::disk('public')->delete($rc->scan_penilaian);
        }

        // Simpan file ke folder 'uploads' dalam storage/app/public
        $path = $request->file('scan_penilaian')->store('uploads', 'public');

        // Simpan path file dan update status
        $rc->scan_penilaian = $path; // simpan relative path, misal: uploads/abc.pdf
        $rc->status_scan_penilaian = 'sudah';
        $rc->save();

        return redirect()->route('proposal_final.tanggapi', ['id' => $rc->permintaan_mgng_id])
            ->with('success', 'File penilaian berhasil diupload.');
    }

    return back()->withErrors(['scan_penilaian' => 'File gagal diupload.']);
}

public function cetakPenilaian($id)
{
    Carbon::setLocale('id');
    
    $rc = MasterPsrt::with('permintaan.masterMgng.masterSklh', 'notaDinas.masterBdng')->findOrFail($id);

    $pdf = Pdf::loadView('pages.proposal_final.cetakpenilaian', compact('rc'));
    $pdf->setPaper('a4', 'portrait');

    return $pdf->stream("penilaian_{$rc->nama_peserta}.pdf");
}

public function uploadSertifikatForm($id)
{
    $rc = MasterPsrt::findOrFail($id);

    $permohonan = $rc->permintaan;

    return view('pages.proposal_final.uploadsertifikat', compact('rc', 'permohonan'));
}

public function simpanUploadSertifikat(Request $request, $id)
{
    $rc = MasterPsrt::findOrFail($id);

    $request->validate([
        'scan_sertifikat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // max 10MB
    ]);

    if ($request->hasFile('scan_sertifikat')) {
        // Hapus file lama jika ada
        if ($rc->scan_sertifikat) {
            Storage::disk('public')->delete($rc->scan_sertifikat);
        }

        // Simpan file ke folder 'uploads' dalam storage/app/public
        $path = $request->file('scan_sertifikat')->store('uploads', 'public');

        // Simpan path file dan update status
        $rc->scan_sertifikat = $path; // simpan relative path, misal: uploads/abc.pdf
        $rc->status_sertifikat = 'terkirim';
        $rc->save();

        return redirect()->route('proposal_final.tanggapi', ['id' => $rc->permintaan_mgng_id])
            ->with('success', 'File sertifikat berhasil diupload.');
    }

    return back()->withErrors(['scan_sertifikat' => 'File gagal diupload.']);
}
}