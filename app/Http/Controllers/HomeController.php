<?php

namespace App\Http\Controllers;

use App\Models\MasterSklh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    $this->checkUserDataCompletion();

    //    ini notifikasi
        $notifikasi = DB::table('permintaan_mgng')
            ->where('status_baca_surat_permintaan', 'belum')
            ->orderBy('created_at', 'desc')
            ->get();

        $jumlahBaru = $notifikasi->count();
    // chart data
    $chartData = [
    'categories' => ['Pendaftar', 'Verifikasi Dokumen', 'Penempatan Bidang', 'Orientasi', 'Pelaksanaan', 'Evaluasi', 'Sertifikat'],
    'series' => [
        [
            'name' => 'Selesai',
            'data' => [
                DB::table('master_psrt')->where('scan_sertifikat', 'selesai')->count(),
                DB::table('master_psrt')->where('scan_sertifikat', 'selesai')->count(),
                DB::table('master_psrt')->where('scan_sertifikat', 'selesai')->count(),
                DB::table('master_psrt')->where('scan_sertifikat', 'selesai')->count(),
                DB::table('master_psrt')->where('scan_sertifikat', 'selesai')->count(),
                DB::table('master_psrt')->where('scan_sertifikat', 'selesai')->count(),
                DB::table('master_psrt')->where('scan_sertifikat', 'terkirim')->count(),
            ]
        ],
        [
            'name' => 'Pending',
            'data' => [
                DB::table('master_psrt')->where('scan_sertifikat', 'pending')->count(),
                DB::table('master_psrt')->where('scan_sertifikat', 'pending')->count(),
                DB::table('master_psrt')->where('scan_sertifikat', 'pending')->count(),
                DB::table('master_psrt')->where('scan_sertifikat', 'pending')->count(),
                DB::table('master_psrt')->where('scan_sertifikat', 'pending')->count(),
                DB::table('master_psrt')->where('scan_sertifikat', 'pending')->count(),
                DB::table('master_psrt')->where('scan_sertifikat', 'belum')->count(),
            ]
        ]
    ]
];

    $ringkasan = File::exists(public_path('data/ringkasan.json'))
        ? json_decode(File::get(public_path('data/ringkasan.json')), true)
        : [];

    // 🔥 Tambahkan ini:
    $selesai = DB::table('master_psrt')
        ->whereNotNull('scan_sertifikat')
        ->where('status_sertifikat', 'terkirim')
        ->count();

    $belum = DB::table('master_psrt')
        ->where(function ($query) {
            $query->whereNull('scan_sertifikat')
                  ->orWhere('scan_sertifikat', '');
        })
        ->where('status_sertifikat', 'belum')
        ->count();
    // ini untuk fitur ringkasan
// Jumlah peserta yang sudah selesai magang
        $totalSelesai = DB::table('master_psrt')
            ->where('status_sertifikat', 'terkirim')
            ->count();

        // Jumlah peserta yang masih aktif (belum terkirim sertifikatnya)
        $masihAktif = DB::table('master_psrt')
            ->where(function ($query) {
                $query->where('status_sertifikat', '!=', 'terkirim')
                      ->orWhereNull('status_sertifikat');
            })
            ->count();

        // Persentase selesai
        $persentase = round(($totalSelesai / max(1, ($totalSelesai + $masihAktif))) * 100);

        $ringkasan = [
            [
                'value' => $totalSelesai,
                'label' => 'Total Peserta Selesai'
            ],
            [
                'value' => $masihAktif,
                'label' => 'Masih Aktif Magang'
            ],
            [
                'value' => $persentase,
                'label' => 'Persentase Selesai'
            ],
        ];

    // Kirim semua data ke view beranda
    return view('pages.home.index', compact(
        'notifikasi',
        'chartData',
        'selesai',
        'ringkasan',
        'belum',
        'jumlahBaru'
    ));
}
}




