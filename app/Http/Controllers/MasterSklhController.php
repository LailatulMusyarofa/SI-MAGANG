<?php

namespace App\Http\Controllers;

use App\Models\MasterSklh;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MasterSklhController extends Controller
{   

    public function index(Request $request)
{
    $keyword = $request->keyword;

    // Query untuk mengambil data lembaga pendidikan dengan pagination
    $query = MasterSklh::join('users', 'users.id', '=', 'master_sklh.id_user')
        ->select('master_sklh.*', 'users.fullname', 'users.akun_diverifikasi')
        ->orderBy('users.fullname', 'asc');

    if ($keyword) {
        $query->where(function($q) use($keyword) {
            $q->where('users.fullname', 'like', "%{$keyword}%")
              ->orWhere('master_sklh.kabko_sklh', 'like', "%{$keyword}%");
        });
    }

    // Hitung jumlah lembaga pendidikan yang belum diverifikasi
    $unverifiedCount = MasterSklh::join('users', 'users.id', '=', 'master_sklh.id_user')
        ->where('users.akun_diverifikasi', 'belum')
        ->count();

    // Ambil data lembaga pendidikan
    $data = $query->paginate(10);

    return view('pages.master_sklh.daftar', compact('data', 'unverifiedCount'));
}



public function verify($id)
{
    $data = MasterSklh::with('user')->findOrFail($id);
    return view('pages.master_sklh.verify', ['rc' => $data]);
}

public function verification($id, Request $req)
{
    // Mengambil data lembaga dan user terkait
    $data = MasterSklh::with('user')->findOrFail($id);
    $user = $data->user;

    // Toggle status verifikasi akun
    $newStatus = in_array($user->akun_diverifikasi, ['belum', 'suspended']) ? 'sudah' : 'suspended';

    // Mengubah status verifikasi akun
    $user->akun_diverifikasi = $newStatus;
    $result = $user->save();

    if ($result) {
        // Perbarui session 'isDataComplete' hanya jika akun berhasil diverifikasi
        session(['isDataComplete' => $newStatus === 'sudah']);

        // Redirect ke halaman master_sklh
        return redirect()->route('master_sklh')->with('result', 'update');
    } else {
        return back()->with('result', 'fail');
    }
}

public function suspend($id, Request $request)
{
    // Ambil data lembaga dan user terkait
    $data = MasterSklh::with('user')->findOrFail($id);
    $user = $data->user;

    // Set akun menjadi 'suspended'
    $user->akun_diverifikasi = 'suspended';
    $result = $user->save();

    if ($result) {
        // Perbarui session 'isDataComplete' jika akun sudah disuspend
        session(['isDataComplete' => false]);

        // Redirect kembali ke halaman daftar lembaga
        return redirect()->route('master_sklh')->with('result', 'Account suspended');
    } else {
        return back()->with('result', 'fail');
    }
}


public function delete(Request $req)
  {
    $result = MasterSklh::find($req->id);
    if ($result->delete()) {
      return redirect()->route('master_sklh')->with('result_dlt', 'Lembaga telah dihapus!');
    } else {
      return back()->with('result_dlt', 'Gagal menghapus lembaga');
    }
  }

public function unlock($id, Request $request)
{
    // Ambil data lembaga dan user terkait
    $data = MasterSklh::with('user')->findOrFail($id);
    $user = $data->user;

    // Set akun menjadi 'sudah' (membuka blokir)
    $user->akun_diverifikasi = 'sudah';
    $result = $user->save();

    if ($result) {
        // Perbarui session 'isDataComplete' jika akun sudah dibuka blokirnya
        session(['isDataComplete' => true]);

        // Redirect kembali ke halaman daftar lembaga
        return redirect()->route('master_sklh')->with('result', 'Account unlocked');
    } else {
        return back()->with('result', 'fail');
    }
}


  public function edit($id)
  {
      $data = MasterSklh::findOrFail($id); 
      return view('pages.master_sklh.edit', compact('data'));
  }
  
  public function update(Request $request)
{
    $id = $request->input('id'); 
    $data = MasterSklh::findOrFail($id);

    if (!$data) {
        return back()->withErrors(['error' => 'Data tidak ditemukan.']);
    }

    // Validasi input
    $validated = $request->validate([
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

    // Upload file jika ada
    if ($request->hasFile('scan_surat_akreditasi_sklh')) {
        $file = $request->file('scan_surat_akreditasi_sklh');
        $filename = time() . '_' . str_replace(' ', '', $file->getClientOriginalName());
        $file->storeAs('public/scan_surat_akreditasi_sklh', $filename);
        $validated['scan_surat_akreditasi_sklh'] = $filename;
    }

    // Update data
    $data->update($validated);

    // Redirect dengan pesan sukses
    return redirect()->route('master_sklh')->with('result', 'Data lembaga telah diperbarui');
}

public function resetPassword(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    $user = User::find($request->user_id);

    if (!$user) {
        return back()->withErrors(['error' => 'User tidak ditemukan.']);
    }

    $user->password = bcrypt('instansi'); 
    $user->save();

    return redirect()->route('master_sklh')->with('result', 'Password user berhasil direset ke "Instansi"');
}

}
