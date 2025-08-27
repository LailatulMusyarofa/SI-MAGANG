<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MagangChartController extends Controller
{
    /**
     * Menampilkan view halaman magang.
     */
    public function index()
    {
        return view('pages.home.fitur.magang');
    }

    /**
     * Mengambil data untuk grafik.
     */
    public function chartData()
    {
        // === Grafik Line: Magang Aktif per Bidang ===
        $aktif = DB::table('balasan_mgng')
            ->join('master_bdng_member', 'balasan_mgng.id_bdng_member', '=', 'master_bdng_member.id')
            ->selectRaw("DATE_FORMAT(tanggal_awal_magang, '%b %y') as bulan")
            ->selectRaw('COUNT(balasan_mgng.id) as total_magang')
            ->selectRaw("SUM(CASE WHEN status_surat_balasan = 'terkirim' THEN 1 ELSE 0 END) as progress_magang")
            ->selectRaw("COUNT(DISTINCT balasan_mgng.id_bdng_member) as bidang_magang")
            ->groupBy('bulan')
            ->orderByRaw("STR_TO_DATE(CONCAT('01 ', bulan), '%d %b %y')")
            ->get();

        // === Grafik Donut: Magang Lulus per Bidang ===
        $whereBidang = [
            'Sekretariat',
            'Bidang Aplikasi Informatika',
            'Bidang Data dan Statistik',
            'Bidang Komunikasi Publik',
            'Bidang Persandian dan Keamanan'
        ];

            // Mengambil data bidang magang yang lulus
        $lulus = DB::table('master_psrt')
            ->join('master_bdng_member', 'master_psrt.id_bdng_member', '=', 'master_bdng_member.id')
            ->join('master_bdng', 'master_bdng_member.id_bdng', '=', 'master_bdng.id')
            ->select('master_bdng.nama_bidang')
            ->whereIn('master_bdng.nama_bidang', $whereBidang)
            ->where('master_psrt.status_sertifikat', 'terkirim')
            ->groupBy('master_bdng.nama_bidang')
            ->selectRaw('count(master_psrt.id) as total')
            ->get();
        

        // === Kartu Tingkat Penerimaan ===
        $totalPendaftar = DB::table('master_psrt')->count();
        $totalLulus = DB::table('master_psrt')->where('status_sertifikat', 'terkirim')->count();
        $persentaseDiterima = $totalPendaftar > 0 ? round(($totalLulus / $totalPendaftar) * 100) : 0;



        // === Durasi Magang Rata-Rata ===
        $durasi = DB::table('balasan_mgng')
            ->selectRaw('AVG(DATEDIFF(tanggal_akhir_magang, tanggal_awal_magang)) as rata_rata')
            ->first();

        return response()->json([
            'aktif' => $aktif,
            'lulus' => $lulus,
            'tingkat_penerimaan' => $persentaseDiterima,
            'durasi_bulanan' => round(($durasi->rata_rata ?? 0) / 30, 1), // dibagi 30 untuk konversi ke bulan
        ]);
    }
}
