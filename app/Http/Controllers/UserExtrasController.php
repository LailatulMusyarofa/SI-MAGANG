<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Menu;
use App\Models\MasterSklh;
use App\Models\PermintaanMgng;
use App\Models\BalasanMgng;
use App\Models\MasterMgng;
use App\Models\MasterPsrt;
use App\Models\NotaDinas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class UserExtrasController extends Controller
{
    public function index()
{
    
    if (request()->routeIs('buat_permohonan')) {
        return view('pages.user_extras.buatproposalmagang');
    }

    return view('pages.user_extras.addsklh');
}
    public function store(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'jenis' => 'required',
        'alamat' => 'required',
        'kabko_sklh' => 'required',
        'akreditasi' => 'required',
        'telepon_lembaga' => 'required',
        'no_akreditasi' => 'required',
        'nama_narahubung' => 'required',
        'jenis_kelamin' => 'required',
        'jabatan_narahubung' => 'required',
        'telepon_narahubung' => 'required',
        'file_akreditasi' => 'required|file|mimes:pdf,jpeg,png|max:10240',
    ]);

    $filePath = null;
    if ($request->hasFile('file_akreditasi')) {
        $filePath = $request->file('file_akreditasi')->store('uploads', 'public');
    } else {
        return back()->withErrors(['file_akreditasi' => 'File belum diupload.']);
    }

    // Simpan data ke tabel master_sklh
    $data = MasterSklh::create([
        'id_user' => Auth::id(),
        'jenis_sklh' => $request->jenis,
        'alamat_sklh' => $request->alamat,
        'kabko_sklh' => $request->kabko_sklh,
        'telp_sklh' => $request->telepon_lembaga,
        'akreditasi_sklh' => $request->akreditasi,
        'no_akreditasi_sklh' => $request->no_akreditasi,
        'scan_surat_akreditasi_sklh' => $filePath,  
        'nama_narahubung' => $request->nama_narahubung,
        'jenis_kelamin_narahubung' => $request->jenis_kelamin,
        'jabatan_narahubung' => $request->jabatan_narahubung,
        'handphone_narahubung' => $request->telepon_narahubung,
    ]);

    // Update is_data_completed di tabel users
    User::where('id', Auth::id())->update(['is_data_completed' => true]);

    // Perbarui session 'isDataComplete' agar status pengisian data reflektif
    session(['isDataComplete' => true]);

    // Redirect ke halaman yang sesuai setelah data berhasil disimpan
    return redirect()->route('user_extras.viewsklh', $data->id)
                     ->with('result', 'Data berhasil disimpan! Menunggu verifikasi admin.');
}


public function show()
    {
        // ambil data milik user yang sedang login
        $dt = MasterSklh::where('id_user', Auth::id())
            ->join('users', 'users.id', '=', 'master_sklh.id_user')
            ->select('master_sklh.*', 'users.fullname', 'users.email')
            ->firstOrFail();

        return view('pages.user_extras.viewsklh', compact('dt'));
    }

public function edit()
{
    $data=MasterSklh::where('id_user',Auth::id())->first();
    return view('pages.user_extras.editsklh',['dt'=>$data]);
}

public function updatesklh(Request $req)
{
    $data = MasterSklh::where('id_user', Auth::id())->first();

    $validated = $req->validate([
        'jenis_sklh' => 'required',
        'alamat_sklh' => 'required',
        'kabko_sklh' => 'required',
        'telp_sklh' => 'required|unique:master_sklh,telp_sklh,' . $data->id,
        'akreditasi_sklh' => 'required',
        'no_akreditasi_sklh' => 'required|unique:master_sklh,no_akreditasi_sklh,' . $data->id,
        'scan_surat_akreditasi_sklh' => 'nullable|mimes:pdf,doc,docx|max:10000',
        'nama_narahubung' => 'required',
        'jenis_kelamin_narahubung' => 'required',
        'jabatan_narahubung' => 'required',
        'handphone_narahubung' => 'required|unique:master_sklh,handphone_narahubung,' . $data->id,
    ]);

    // Handle file upload if any
    if ($req->hasFile('scan_surat_akreditasi_sklh')) {
        $file = $req->file('scan_surat_akreditasi_sklh');
        $filename = time() . '_' . str_replace(' ', '', $file->getClientOriginalName());
        $file->storeAs('public/scan_surat_akreditasi_sklh', $filename);
        $validated['scan_surat_akreditasi_sklh'] = $filename;
    }

    $result = MasterSklh::where('id_user', Auth::id())->update($validated);

    return $result
        ? redirect()->route('user_extras.viewsklh')->with('result', 'success')
        : back()->with('result', 'fail');
}

public function simpanproposalmagang(Request $request)
{
    // Ambil data sekolah yang login
    $datasklh = MasterSklh::where('id_user', Auth::id())->firstOrFail();

    // Cek atau buat master_mgng untuk sekolah ini
    $masterMgng = MasterMgng::firstOrCreate([
        'master_sklh_id' => $datasklh->id
    ]);

    // Validasi input
    $validated = $request->validate([
        'nomor_surat_permintaan' => 'required|unique:permintaan_mgng,nomor_surat_permintaan',
        'tanggal_surat_permintaan' => 'required|date',
        'perihal_surat_permintaan' => 'required',
        'ditandatangani_oleh' => 'required',
        'file_surat_permintaan' => 'required|file|mimes:pdf,jpeg,png|max:10240',
        'file_proposal_magang' => 'required|file|mimes:pdf,jpeg,png|max:10240',
    ]);

    // Upload file Surat Permintaan
    $filePathSurat = null;
    if ($request->hasFile('file_surat_permintaan')) {
        $filePathSurat = $request->file('file_surat_permintaan')->store('uploads', 'public');
    } else {
        return back()->withErrors(['file_surat_permintaan' => 'File belum diupload.']);
    }

    // Upload file Proposal Magang
    $filePathProposal = null;
    if ($request->hasFile('file_proposal_magang')) {
        $filePathProposal = $request->file('file_proposal_magang')->store('uploads', 'public');
    } else {
        return back()->withErrors(['file_proposal_magang' => 'File belum diupload.']);
    }

    // Simpan ke permintaan_mgng
    PermintaanMgng::create([
        'master_mgng_id' => $masterMgng->id,
        'nomor_surat_permintaan' => $validated['nomor_surat_permintaan'],
        'tanggal_surat_permintaan' => $validated['tanggal_surat_permintaan'],
        'perihal_surat_permintaan' => $validated['perihal_surat_permintaan'],
        'ditandatangani_oleh' => $validated['ditandatangani_oleh'],
        'scan_surat_permintaan' => $filePathSurat, 
        'scan_proposal_magang' => $filePathProposal,
        'status_surat_permintaan' => 'belum',
        'status_baca_surat_permintaan' => 'belum',
    ]);

    return redirect()->route('user.daftar_permohonan')->with('result', 'success');
}



public function daftarPermohonanKeluar()
{
    // Ambil data master_sklh berdasarkan user yang login
    $masterSklh = MasterSklh::where('id_user', Auth::id())->first();

    if (!$masterSklh) {
        abort(404, 'Sekolah tidak ditemukan.');
    }

    // Ambil data master_mgng berdasarkan master_sklh_id
    $masterMgng = MasterMgng::where('master_sklh_id', $masterSklh->id)->first();

    if (!$masterMgng) {
        abort(404, 'Data master magang belum tersedia.');
    }

    // Ambil semua permintaan magang dengan relasi balasan yang status_surat_balasan-nya tidak "terkirim"
    $permintaan = PermintaanMgng::where('master_mgng_id', $masterMgng->id)
        ->whereDoesntHave('balasan', function($query) {
            $query->where('status_surat_balasan', 'terkirim');
        })
        ->get();

    // Ambil data peserta magang jika perlu
    $data2 = MasterPsrt::all();

    return view('pages.user_extras.daftarpermohonankeluar', compact('permintaan', 'data2'));
}


public function viewPermohonanKeluar($id)
{
    // Ambil data permohonan berdasarkan ID yang diterima dari route
    $permohonan = PermintaanMgng::findOrFail($id);

    // Ambil peserta berdasarkan permintaan_mgng_id
    $peserta = MasterPsrt::where('permintaan_mgng_id', $permohonan->id)->get();

    // Kirimkan data ke view
    return view('pages.user_extras.viewpermohonankeluar', compact('permohonan', 'peserta'));
}




public function updatestatuspermohonan(Request $request, $id)
{
    // Ambil permohonan berdasarkan ID
    $permohonan = PermintaanMgng::findOrFail($id);

    // Pastikan status saat ini adalah 'belum'
    if ($permohonan->status_surat_permintaan == 'belum') {
        // Ubah status menjadi 'terkirim' (atau Menunggu Persetujuan)
        $permohonan->status_surat_permintaan = 'terkirim'; // Atur status menjadi "terkirim"
        $permohonan->save(); // Simpan perubahan

        // Redirect ke halaman yang sama (viewpermohonankeluar) setelah mengubah status
        return redirect()->route('user.viewpermohonankeluar', ['id' => $permohonan->id])
                         ->with('result_mohon', 'Menungggu balasan permohonan'); // Notifikasi berhasil
    }

    // Jika status tidak sesuai
    return redirect()->route('user.viewpermohonankeluar', ['id' => $id])
                     ->with('result', 'fail-update'); 
}

public function editpermohonan($id)
{
    // Ambil permohonan berdasarkan ID yang diberikan
    $permohonan = PermintaanMgng::findOrFail($id);

    // Mengirimkan data permohonan ke view
    return view('pages.user_extras.editpermohonankeluar', compact('permohonan'));
}

public function updatepermohonan(Request $request, $id)
{
    // Validasi input
    $validated = $request->validate([
        'nomor_surat_permintaan' => 'required',
        'tanggal_surat_permintaan' => 'required|date',
        'perihal_surat_permintaan' => 'required',
        'ditandatangani_oleh' => 'required',
        'scan_surat_permintaan' => 'nullable|file|mimes:pdf,jpg,png|max:10240',
        'scan_proposal_magang' => 'nullable|file|mimes:pdf,jpg,png|max:10240',
    ]);

    // Ambil permohonan berdasarkan ID
    $permohonan = PermintaanMgng::findOrFail($id);

    // Update data permohonan dengan input yang telah divalidasi
    $permohonan->update($validated);

    // Handle file upload jika ada
    if ($request->hasFile('scan_surat_permintaan')) {
    $filePathSurat = $request->file('scan_surat_permintaan')->store('uploads/scan_surat_permintaan', 'public');
    $permohonan->scan_surat_permintaan = $filePathSurat;
    }

    if ($request->hasFile('scan_proposal_magang')) {
        $filePathProposal = $request->file('scan_proposal_magang')->store('uploads/scan_proposal_magang', 'public');
        $permohonan->scan_proposal_magang = $filePathProposal;
    }

    // Simpan perubahan permohonan
    $permohonan->save();

    // Redirect ke halaman detail permohonan setelah berhasil diupdate
    return redirect()->route('user.viewpermohonankeluar', ['id' => $permohonan->id])
                     ->with('result_edit', 'Informasi berhasil diperbarui!');
}


public function addPesertaMagang($id)
{
    // Ambil permohonan berdasarkan ID yang diberikan
    $permohonan = PermintaanMgng::findOrFail($id);
    
    // Mengirim data ke view
    return view('pages.user_extras.addpesertamagang', compact('permohonan'));
}

public function simpanpesertamagang($id, Request $request)
{
    // Validasi input
     $validated = $request->validate([
        'nama_peserta' => 'required',
        'nik_peserta' => [
            'required',
            Rule::unique('master_psrt')->where(function ($query) use ($id) {
                return $query->where('permintaan_mgng_id', $id);
            }),
        ],
        'nis_peserta' => [
            'required',
            Rule::unique('master_psrt')->where(function ($query) use ($id) {
                return $query->where('permintaan_mgng_id', $id);
            }),
        ],
        'program_studi' => 'required',
        'no_handphone_peserta' => [
            'required',
            Rule::unique('master_psrt')->where(function ($query) use ($id) {
                return $query->where('permintaan_mgng_id', $id);
            }),
        ],
        'email_peserta' => [
            'required',
            'email',
            Rule::unique('master_psrt')->where(function ($query) use ($id) {
                return $query->where('permintaan_mgng_id', $id);
            }),
        ],
        'jenis_kelamin' => 'required',
    ]);

    // Cek apakah permintaan magang ada
    $permintaan = PermintaanMgng::findOrFail($id);

    // Simpan data peserta
    $result = new MasterPsrt();
    $result->permintaan_mgng_id = $id; // Simpan ID permintaan_mgng ke kolom permintaan_mgng_id
    $result->fill($validated);
    $result->save();

    return redirect()
        ->route('user.viewpermohonankeluar', ['id' => $id])
        ->with('result_psrt', 'Peserta berhasil ditambahkan!');
}

public function hapusPesertaMagang(Request $request, $id)
{
    // Pastikan peserta ada
    $peserta = MasterPsrt::findOrFail($id);

    // Hapus peserta
    $peserta->delete();

    // Redirect kembali ke halaman detail permohonan tanpa mengubah status
    return redirect()->route('user.viewpermohonankeluar', ['id' => $peserta->permintaan_mgng_id])->with('result', 'Peserta telah dihapus!');
}

public function editPesertaMagang($id)
{
    // Ambil peserta berdasarkan ID yang diberikan
    $peserta = MasterPsrt::findOrFail($id);

    // Ambil permohonan yang terkait dengan peserta
    $permohonan = PermintaanMgng::findOrFail($peserta->permintaan_mgng_id);

    // Mengirimkan data peserta dan permohonan ke view
    return view('pages.user_extras.editpesertamagang', compact('peserta', 'permohonan'));
}

public function updatePesertaMagang(Request $request, $id)
{
    // Ambil data peserta berdasarkan ID
    $peserta = MasterPsrt::findOrFail($id);

    // Validasi input
    $validated = $request->validate([
        'nama_peserta' => 'required',
        'nik_peserta' => 'required|unique:master_psrt,nik_peserta,' . $peserta->id,
        'nis_peserta' => 'required|unique:master_psrt,nis_peserta,' . $peserta->id,
        'program_studi' => 'required',
        'no_handphone_peserta' => 'required|unique:master_psrt,no_handphone_peserta,' . $peserta->id,
        'email_peserta' => 'required|email|unique:master_psrt,email_peserta,' . $peserta->id,
        'jenis_kelamin' => 'required',
    ]);

    // Update data peserta dengan input yang telah divalidasi
    $peserta->update($validated);

    // Redirect ke halaman detail permohonan setelah berhasil diupdate
    return redirect()->route('user.viewpermohonankeluar', ['id' => $peserta->permintaan_mgng_id])
                     ->with('result', 'success');
}



    public function hapusPermohonan($id)
{
    $permohonan = PermintaanMgng::find($id);


    if (!$permohonan) {
        return redirect()->route('user.daftar_permohonan')->with('error', 'Permohonan tidak ditemukan.');
    }

    $permohonan->delete();

    return redirect()->route('user.daftar_permohonan')->with('success', 'Permohonan berhasil dihapus.');
}

public function daftarPermohonanMasuk(Request $req)
{   
    Carbon::setLocale('id');

    // Ambil data master_sklh berdasarkan user yang login
    $masterSklh = MasterSklh::where('id_user', Auth::id())->first();

    if (!$masterSklh) {
        abort(404, 'Sekolah tidak ditemukan.');
    }

    // Ambil data master_mgng berdasarkan master_sklh_id
    $masterMgng = MasterMgng::where('master_sklh_id', $masterSklh->id)->first();

    if (!$masterMgng) {
        abort(404, 'Data master magang belum tersedia.');
    }

    // Ambil semua permintaan magang dengan relasi balasan yang status_surat_balasan-nya "terkirim"
    $permintaan = PermintaanMgng::with('balasan') // Memuat relasi balasan
        ->where('master_mgng_id', $masterMgng->id)
        ->whereHas('balasan', function($query) {
            $query->where('status_surat_balasan', 'terkirim');
        })
        ->get();

    // Ambil data peserta magang jika perlu
    $data2 = MasterPsrt::all(); 

    return view('pages.user_extras.daftarpermohonanmasuk', compact('permintaan', 'data2'));
}

public function detailPermohonanMasuk($id) 
{
    // Ambil data permohonan berdasarkan ID, termasuk data balasan
    $rc = PermintaanMgng::with('balasan')->findOrFail($id);  // Including balasan data

    // Periksa apakah balasan ada dan status_surat_balasan adalah 'terkirim' dan status_baca_surat_balasan 'belum'
    $balasan = $rc->balasan; // Mengambil balasan terkait
    
    if ($balasan && $balasan->status_surat_balasan == 'terkirim' && $balasan->status_baca_surat_balasan == 'belum') {
        // Perbarui status_baca_surat_balasan menjadi 'dibaca'
        $balasan->status_baca_surat_balasan = 'dibaca';
        $balasan->save();  // Simpan perubahan
    }

    // Ambil data peserta yang terkait dengan permohonan ini
    $rd = MasterPsrt::where('permintaan_mgng_id', $rc->id)->get();

    // Kirimkan data ke view
    return view('pages.user_extras.viewpermohonanmasuk', compact('rc', 'rd'));
}

public function daftarLaporanMagang(Request $req)
{
    Carbon::setLocale('id');

    // Get the logged-in user's school/institiution
    $masterSklh = MasterSklh::where('id_user', Auth::id())->first();

    if (!$masterSklh) {
        abort(404, 'Sekolah tidak ditemukan.');
    }

    // Now filter PermintaanMgng based on the logged-in user's school
    $data = PermintaanMgng::with(['masterMgng.masterSklh.user', 'balasan', 'notaDinas.masterBdng'])
        ->whereHas('masterMgng', function ($query) use ($masterSklh) {
            $query->where('master_sklh_id', $masterSklh->id); // Filter by user's school
        })
        ->whereHas('notaDinas', function ($query) {
            $query->where('status_nota_dinas', 'terkirim');
        })
        ->when($req->keyword, function ($query, $keyword) {
            $query->whereHas('masterMgng.masterSklh.user', function ($q) use ($keyword) {
                $q->where('fullname', 'like', "%{$keyword}%")
                  ->orWhere('alamat_sklh', 'like', "%{$keyword}%")
                  ->orWhere('telp_sklh', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%")
                  ->orWhere('no_akreditasi_sklh', 'like', "%{$keyword}%")
                  ->orWhere('nama_narahubung', 'like', "%{$keyword}%");
            });
        })
        ->orderBy('created_at', 'desc')
        ->get();

    // Ambil data peserta magang jika perlu
    $data2 = MasterPsrt::all();

    return view('pages.user_extras.daftarlaporan', compact('data', 'data2'));
}

public function showUploadLaporan($id)
{
    // Ambil permohonan berdasarkan ID
    $permohonan = PermintaanMgng::findOrFail($id);

    // Cek apakah tanggal akhir magang sudah lewat atau belum
    $canUpload = now()->isSameDay(\Carbon\Carbon::parse($permohonan->balasan->tanggal_akhir_magang)) || now()->isAfter(\Carbon\Carbon::parse($permohonan->balasan->tanggal_akhir_magang));

    // Tampilkan form upload laporan dan informasikan statusnya
    return view('pages.user_extras.uploadlaporan', compact('permohonan', 'canUpload'));
}

public function uploadLaporan(Request $request, $id)
{
    // Validasi file upload
    $request->validate([
        'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // Maksimal 10MB
    ]);

    // Ambil permohonan berdasarkan ID
    $permohonan = PermintaanMgng::findOrFail($id);

    // Pastikan tanggal akhir magang sudah lewat
    if (now()->lt(\Carbon\Carbon::parse($permohonan->balasan->tanggal_akhir_magang))) {
        return redirect()->back()->with('error', 'Form laporan tidak dapat diakses karena magang belum selesai.');
    }

    // Cari nota dinas berdasarkan permintaan_mgng_id
    $notaDinas = NotaDinas::where('permintaan_mgng_id', $permohonan->id)->first();

    if (!$notaDinas) {
        return redirect()->back()->with('error', 'Nota Dinas tidak ditemukan.');
    }

    // Menyimpan file yang diupload
    if ($request->hasFile('file')) {
        $path = $request->file('file')->store('uploads/laporan', 'public');

        // Update path file dan status laporan
        $notaDinas->scan_laporan_magang = $path;
        $notaDinas->status_laporan = 'terkirim';
        $notaDinas->save();

        return redirect()->route('user.daftar_laporanmagang')->with('success', 'Laporan berhasil diunggah!');
    }

    return redirect()->back()->with('error', 'Tidak ada file yang diupload.');
}
public function previewLaporan($id)
{
    // Ambil permohonan berdasarkan ID
    $permohonan = PermintaanMgng::findOrFail($id);

    // Cari nota dinas berdasarkan permintaan_mgng_id
    $notaDinas = NotaDinas::where('permintaan_mgng_id', $permohonan->id)->first();

    if (!$notaDinas || !$notaDinas->scan_laporan_magang) {
        return redirect()->back()->with('error', 'Laporan tidak ditemukan.');
    }

    // Menyusun path file yang ada di direktori penyimpanan
    $filePath = 'uploads/laporan/' . basename($notaDinas->scan_laporan_magang);

    // Pastikan file ada di penyimpanan publik
    if (Storage::disk('public')->exists($filePath)) {
        // Ambil file dan kirimkan sebagai response
        $file = Storage::disk('public')->get($filePath);
        
        // Untuk PDF file, beri header Content-Type yang tepat
        return response($file, 200)->header('Content-Type', 'application/pdf');
    }

    return redirect()->back()->with('error', 'File tidak ditemukan.');
}
public function viewPesertaMasuk($id)
{
    // Ambil data peserta berdasarkan ID
    $data = MasterPsrt::findOrFail($id);

    // Ambil permohonan terkait dengan peserta
    $rc = PermintaanMgng::where('id', $data->permintaan_mgng_id)->first();

    // Kirim data peserta dan permohonan ke view
    return view('pages.user_extras.viewpesertamasuk', compact('data', 'rc'));
}

}

