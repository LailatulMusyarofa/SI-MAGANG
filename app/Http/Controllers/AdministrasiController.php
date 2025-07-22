<?php

namespace App\Http\Controllers;

use App\Models\Administrasi;
use Illuminate\Http\Request;

class AdministrasiController extends Controller
{
    public function store(Request $request)
    {
        Administrasi::create($request->all());
        return redirect()->route('master_administrasi')->with('success', 'Data berhasil ditambahkan!');
    }

    public function index()
    {
        $data = Administrasi::all();
        return view('pages.master_administrasi.administrasi', compact('data'));
    }

    public function edit($id)
    {
        $item = Administrasi::findOrFail($id);
        return view('pages.master_administrasi.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Administrasi::findOrFail($id);
        $item->update($request->only(['nama', 'status', 'keterangan']));
        return redirect()->route('master_administrasi')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Administrasi::destroy($id);
        return back()->with('success', 'Data berhasil dihapus!');
    }
}
