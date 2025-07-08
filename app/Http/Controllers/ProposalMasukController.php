<?php

namespace App\Http\Controllers;

use App\Models\MasterPsrt;
use App\Models\PermintaanMgng;
use App\Models\BalasanMgng;
use App\Models\MasterBdngMember;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProposalMasukController extends Controller
{
    public function index(Request $req)
{
    Carbon::setLocale('id');
    
    // Ambil data permohonan magang beserta relasi, hanya permohonan yang belum dibalas (status_surat_balasan != 'terkirim')
    $data = PermintaanMgng::with(['masterMgng.masterSklh.user'])
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
        // Pastikan hanya permohonan yang tidak memiliki balasan dengan status 'terkirim'
        ->whereDoesntHave('balasan', function ($query) {
            $query->where('status_surat_balasan', 'terkirim');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    // Ambil data peserta magang
    $data2 = MasterPsrt::all();

    return view('pages.proposal_masuk.daftar', compact('data', 'data2'));
}

    public function destroy($id)
{
    $permohonan = PermintaanMgng::findOrFail($id);
    $permohonan->delete();
    return redirect()->route('proposal_masuk')->with('success', 'Permohonan magang berhasil dihapus.');
}

      
   public function cetakpdfpermohonanmasuk($id)
{

    Carbon::setLocale('id');
    
    $rc = PermintaanMgng::findOrFail($id);

    $balasan = BalasanMgng::where('master_mgng_id', $rc->master_mgng_id)->first();

    $rd = MasterPsrt::where('permintaan_mgng_id', $rc->id)->get();

    $pejabat = null;
    if ($balasan->id_bdng_member) {
        $pejabat = MasterBdngMember::find($balasan->id_bdng_member);
    }
    $pdf = Pdf::loadView('pages.proposal_masuk.cetakpdfpermohonanmasuk', compact('rc', 'rd', 'balasan', 'pejabat'));

    return $pdf->stream('PermohonanMagang_' . $rc->nomor_surat_permintaan . '.pdf');
}


    public function balasPermohonan($id)
{
    Carbon::setLocale('id');
    
    $rc = PermintaanMgng::findOrFail($id);

    $rc->status_baca_surat_permintaan = 'dibaca';
    $rc->save();

    $rd = MasterPsrt::where('permintaan_mgng_id', $rc->id)->get();

    return view('pages.proposal_masuk.tanggapiproposal', compact('rc', 'rd'));
}


    public function tanggapiPermohonan(Request $request, $id)
{
    $request->validate([
        'nomor_surat_balasan' => 'required',
        'tanggal_surat_balasan' => 'required|date',
        'sifat_surat_balasan' => 'required',
        'metode_magang' => 'required',
        'lampiran_surat_balasan' => 'nullable|string',
        'scan_surat_balasan' => 'nullable|file|mimes:pdf,jpg,png|max:10240',
        'tanggal_awal_magang' => 'required|date',
        'tanggal_akhir_magang' => 'required|date',
    ]);

    $permohonan = PermintaanMgng::findOrFail($id);

    // Ambil atau buat balasan berdasarkan master_mgng_id
    $balasan = BalasanMgng::firstOrNew([
        'master_mgng_id' => $permohonan->master_mgng_id,
    ]);

    // Menetapkan permintaan_mgng_id pada balasan
    $balasan->permintaan_mgng_id = $permohonan->id;

    // Isi atau update field lainnya
    $balasan->nomor_surat_balasan = $request->nomor_surat_balasan;
    $balasan->tanggal_surat_balasan = $request->tanggal_surat_balasan;
    $balasan->sifat_surat_balasan = $request->sifat_surat_balasan;
    $balasan->metode_magang = $request->metode_magang;
    $balasan->lampiran_surat_balasan = $request->lampiran_surat_balasan;
    $balasan->tanggal_awal_magang = $request->tanggal_awal_magang;
    $balasan->tanggal_akhir_magang = $request->tanggal_akhir_magang;
    $balasan->status_surat_balasan = 'terkirim';

    $datamember = MasterBdngMember::where('jabatan_pejabat', 'Sekretaris')->first();
    
    // Cek jika data pejabat ditemukan dan set id_bdng_member
    if ($datamember) {
        $balasan->id_bdng_member = $datamember->id;
    }

    // Simpan awal (tanpa file)
    $balasan->save();

    // Jika ada file diupload, simpan file dan update
    if ($request->hasFile('scan_surat_balasan')) {
        $path = $request->file('scan_surat_balasan')->store('scan_surat_balasan', 'public');
        $filename = basename($path);
        $balasan->scan_surat_balasan = $filename;
        $balasan->save();

        return redirect()->route('proposal_keluar')->with('success', 'Balasan berhasil diperbarui dengan file.');
    }

    // Kembali ke halaman tanggapi proposal
    $rc = $permohonan;
    $rd = MasterPsrt::where('permintaan_mgng_id', $rc->id)->get();

    return view('pages.proposal_masuk.tanggapiproposal', compact('rc', 'rd', 'balasan'))
        ->with('success', 'Data balasan disimpan. Silakan cetak PDF dan upload file jika sudah tersedia.');
}
public function viewPeserta($id)
{
    // Ambil data peserta berdasarkan ID
    $data = MasterPsrt::findOrFail($id);

    // Ambil permohonan terkait dengan peserta
    $rc = PermintaanMgng::where('id', $data->permintaan_mgng_id)->first();

    // Kirim data peserta dan permohonan ke view
    return view('pages.proposal_masuk.viewpeserta', compact('data', 'rc'));
}

}

