<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotifikasiController extends Controller
{
    public function index()
    {
        // return "Test berhasil"; 
        $notifikasi = DB::table('permintaan_mgng')
            ->where('status_baca_surat_permintaan', 'belum')
            ->orderBy('created_at', 'desc')
            ->get();

        $jumlahBaru = $notifikasi->count();

        return view('pages.home.index', compact('notifikasi', 'jumlahBaru'));
    }
}
