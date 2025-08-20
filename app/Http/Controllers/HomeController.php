<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\MasterSklh;
use App\Models\PermintaanMgng;
use App\Models\MasterPsrt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File; //json

use App\Models\NotaDinas;
use App\Models\NotaDinasItem;
use App\Models\MasterBdngMember;
use Barryvdh\DomPDF\Facade\Pdf;

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
    // ... existing code ...

 // pastikan ini ada di atas

// Permohonan Baru (7 hari terakhir)
 // Permohonan Baru
    $permohonanBaru = DB::table('administrasis')
        ->where('status_pengajuan', 'belum diproses')
        ->select('id', 'nama_lembaga', 'created_at')
        ->get()
        ->map(function ($item) {
            return (object)[
                'tipe'   => 'permohonan',
                'pesan'  => "Permohonan Magang Baru dari {$item->nama_lembaga}",
                'waktu'  => $item->created_at,
                'link'   => route('proposal_masuk', $item->id),
                'warna'  => 'blue',
            ];
        });

    // Dokumen Perlu Diverifikasi
    $dokumenPerluDiverifikasi = PermintaanMgng::with(['user', 'masterPsrt', 'masterSklh'])
        ->where('status_baca_surat_permintaan', 'belum')
        ->get()
        ->map(function ($item) {
            $nama = $item->masterPsrt->nama_peserta ?? 'Peserta';
            $lembaga = $item->user->fullname ?? 'Lembaga';
            return (object)[
                'tipe'   => 'verifikasi',
                'pesan'  => "$nama dari $lembaga mengajukan permohonan magang",
                'waktu'  => $item->created_at,
                'link'   => route('proposal_masuk', $item->id),
                'warna'  => 'red',
            ];
        });

    // Magang Selesai
    $magangSelesai = MasterPsrt::with('permintaan')
        ->where('status_sertifikat', 'terkirim')
        ->get()
        ->map(function ($item) {
            $lembaga = $item->permintaan?->nama_lembaga ?? 'Lembaga';
            return (object)[
                'tipe'   => 'selesai',
                'pesan'  => "{$item->nama_peserta} dari {$lembaga} telah menyelesaikan program magang",
                'waktu'  => $item->created_at,
                'link'   => route('proposal_final.daftar', $item->id),
                'warna'  => 'green',
            ];
        });

    // Gabungkan semua koleksi jadi satu
    $notifikasi = collect()
        ->merge($permohonanBaru)
        ->merge($dokumenPerluDiverifikasi)
        ->merge($magangSelesai)
        ->sortByDesc('waktu')   // urutkan terbaru di atas
        ->take(7); 

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
        'notifikasi', 'chartData', 'selesai', 'ringkasan', 'belum',
        'permohonanBaru', 'dokumenPerluDiverifikasi', 'magangSelesai'
    ));
}
// public function cetakPdf($id)
// {   
//     Carbon::setLocale('id');
    
//     $notaDinas = NotaDinas::findOrFail($id);
    
//     // Ambil permohonan terkait berdasarkan master_mgng_id
//     $permintaan = PermintaanMgng::where('master_mgng_id', $notaDinas->master_mgng_id)->firstOrFail();

//     // Ambil peserta yang sudah diassign ke nota dinas lewat nota_dinas_item
//     $masterPsrtIds = NotaDinasItem::where('nota_dinas_id', $notaDinas->id)->pluck('master_psrt_id');
//     $peserta = MasterPsrt::whereIn('id', $masterPsrtIds)->get();

//     // Ambil pejabat langsung berdasarkan bdng_member_id di notaDinas
//     $pejabat = null;
//     if ($notaDinas->bdng_member_id) {
//         $pejabat = MasterBdngMember::find($notaDinas->bdng_member_id);
//     }

//     // Generate PDF dari view, gunakan alias Pdf sesuai import
//     $pdf = Pdf::loadView('pages.nota_dinas.cetaknotadinas', compact('notaDinas', 'permintaan', 'peserta', 'pejabat'));
    
//     // Stream PDF (buka di tab baru)
//     return $pdf->stream('nota_dinas_' . $notaDinas->nomor_nota_dinas . '.pdf');
// }
}




