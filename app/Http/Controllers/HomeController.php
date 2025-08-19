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
    
        // Ambil isi notifikasi dari file JSON
        $notifikasi = json_decode(File::get(resource_path('data/notifikasi.json')), true);
    
        // Ambil data peserta dan nama universitas
        $pesertaData = DB::table('master_psrt')
            ->join('permintaan_mgng', 'master_psrt.permintaan_mgng_id', '=', 'permintaan_mgng.id')
            ->join('master_mgng', 'permintaan_mgng.master_mgng_id', '=', 'master_mgng.id')
            ->join('master_sklh', 'master_mgng.master_sklh_id', '=', 'master_sklh.id')
            ->select('master_psrt.nama_peserta', 'master_sklh.kabko_sklh as universitas')
            ->get();
    
            $chartData = [
                'categories' => ['Pendaftar', 'Verifikasi Dokumen', 'Penempatan Bidang', 'Orientasi', 'Pelaksanaan', 'Evaluasi', 'Sertifikat'],
                'series' => [
                    [
                        'name' => 'Selesai',
                        'data' => [
                            DB::table('master_psrt')->where('scan_sertifikat', 'selesai')->count(), // Pendaftar
                            DB::table('master_psrt')->where('scan_sertifikat', 'selesai')->count(), // Verifikasi
                            DB::table('master_psrt')->where('scan_sertifikat', 'selesai')->count(), // Penempatan
                            DB::table('master_psrt')->where('scan_sertifikat', 'selesai')->count(), // Orientasi
                            DB::table('master_psrt')->where('scan_sertifikat', 'selesai')->count(), // Pelaksanaan
                            DB::table('master_psrt')->where('scan_sertifikat', 'selesai')->count(), // Evaluasi
                            DB::table('master_psrt')->where('status_sertifikat', 'terkirim')->count(), // Sertifikat
                        ]
                    ],
                    [
                        'name' => 'Pending',
                        'data' => [
                            DB::table('master_psrt')->where('scan_sertifikat', 'pending')->count(), // Pendaftar
                            DB::table('master_psrt')->where('scan_sertifikat', 'pending')->count(), // Verifikasi
                            DB::table('master_psrt')->where('scan_sertifikat', 'pending')->count(), // Penempatan
                            DB::table('master_psrt')->where('scan_sertifikat', 'pending')->count(), // Orientasi
                            DB::table('master_psrt')->where('scan_sertifikat', 'pending')->count(), // Pelaksanaan
                            DB::table('master_psrt')->where('scan_sertifikat', 'pending')->count(), // Evaluasi
                            DB::table('master_psrt')->where('status_sertifikat', 'belum')->count(), // Sertifikat
                        ]
                    ]
                ]
            ];
             // Biarkan bagian ini tetap
    
        $ringkasan = File::exists(public_path('data/ringkasan.json'))
            ? json_decode(File::get(public_path('data/ringkasan.json')), true)
            : [];
    
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
    
        return view('pages.home.index', compact(
            'notifikasi',
            'chartData',
            'ringkasan',
            'selesai',
            'belum',
            'pesertaData'
        ));
    }
    

}


