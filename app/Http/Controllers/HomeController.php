<?php

namespace App\Http\Controllers;

use App\Models\MasterSklh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File; //json

class HomeController extends Controller
{
    // Cek apakah user sudah melengkapi data
    public function checkUserDataCompletion()
{
    $user = Auth::user();

    // Cek apakah user sudah melengkapi data di tabel master_sklh
    $dataExist = MasterSklh::where('id_user', $user->id)->exists();

    // Memeriksa status verifikasi akun
    $isVerified = $user->akun_diverifikasi === 'sudah';

    // Menyimpan status ke dalam session
    session(['isDataComplete' => $dataExist && $isVerified]);
}

    // Fungsi untuk halaman utama
    public function index()
    {
        // Panggil fungsi untuk memeriksa status pengisian data pengguna
        $this->checkUserDataCompletion();

        // Notifikasi
    $notifikasi = json_decode(File::get(resource_path('data/notifikasi.json')), true);

    // Chart
    $chartData = json_decode(File::get(resource_path('data/statusAdministrasi.json')), true);

    // Ringkasan
    $ringkasan = File::exists(public_path('data/ringkasan.json'))
        ? json_decode(File::get(public_path('data/ringkasan.json')), true)
        : [];

    // Kirim semua data ke halaman index
    return view('pages.home.index', compact('notifikasi', 'chartData', 'ringkasan'));
    }
}
