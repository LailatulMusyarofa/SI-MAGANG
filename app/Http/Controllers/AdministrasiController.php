<?php

namespace App\Http\Controllers;

use App\Models\Administrasi;
use Illuminate\Http\Request;

class AdministrasiController extends Controller
{
    public function index()
    {
        $data = Administrasi::all();
        return view('pages.master_administrasi.administrasi', compact('data'));
    }

    public function create()
    {
        return view('pages.master_administrasi.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_lembaga' => 'required',
        'alamat' => 'required',
        'kontak' => 'required',
        'email' => 'required|email',
        'narahubung' => 'required',
        'jenis_kelamin' => 'required',
        'jabatan' => 'required',
        'no_hp' => 'required',
        'status_pengajuan' => 'required',
    ]);

    Administrasi::create($request->all());

    return redirect()->route('master_administrasi')->with('success', 'Data berhasil ditambahkan!');
}


    public function view($id)
    {
        $item = Administrasi::findOrFail($id);
        return view('pages.master_administrasi.view', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Administrasi::findOrFail($id);
        $item->update($request->only(['nama', 'status_pengajuan', 'narahubung', 'jenis_kelamin', 'jabatan', 'no_hp']));
        return redirect()->route('master_administrasi')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Administrasi::destroy($id);
        return back()->with('success', 'Data berhasil dihapus!');
    }
}
