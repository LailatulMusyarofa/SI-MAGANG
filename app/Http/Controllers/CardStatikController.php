<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CardStatikController extends Controller
{
    // View halaman
    public function index()
    {
        return view('pages.permohonan');
    }

    // Endpoint JSON untuk card statistik
    public function getCardJson()
    {
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // Permohonan Ditangani -> balasan_mgng dengan status "ditandatangani"
        $permohonanDitandatangani = DB::table('balasan_mgng')
            ->where('status', 'ditandatangani')
            ->count();

        // Permohonan Pending -> balasan_mgng dengan status "pending"
        $permohonanPending = DB::table('balasan_mgng')
            ->where('status', 'pending')
            ->count();

        // Total Magang Aktif -> master_psrt dengan status "aktif"
        $totalMagangAktif = DB::table('master_psrt')
            ->where('status', 'aktif')
            ->count();

        // Lulus bulan ini -> master_psrt dengan status "lulus" dan tanggal_lulus di bulan ini
        $lulusBulanIni = DB::table('master_psrt')
            ->where('status', 'lulus')
            ->whereMonth('tanggal_lulus', $bulanIni)
            ->whereYear('tanggal_lulus', $tahunIni)
            ->count();

        // (Optional) hitung persentase dibanding bulan lalu
        $lulusBulanLalu = DB::table('master_psrt')
            ->where('status', 'lulus')
            ->whereMonth('tanggal_lulus', $bulanIni - 1)
            ->whereYear('tanggal_lulus', $tahunIni)
            ->count();

        $persentaseLulus = $lulusBulanLalu > 0
            ? round((($lulusBulanIni - $lulusBulanLalu) / $lulusBulanLalu) * 100, 1)
            : 0;

        return response()->json([
            'data' => [
                'ditandatangani' => [
                    'jumlah' => $permohonanDitandatangani,
                    'label' => "↗ {$permohonanDitandatangani}% dari bulan lalu"
                ],
                'pending' => [
                    'jumlah' => $permohonanPending,
                    'label' => "↘ {$permohonanPending}% dari bulan lalu"
                ],
                'aktif' => [
                    'jumlah' => $totalMagangAktif,
                    'label' => "↗ {$totalMagangAktif}% dari bulan lalu"
                ],
                'lulus' => [
                    'jumlah' => $lulusBulanIni,
                    'label' => "{$persentaseLulus}% dari bulan lalu"
                ]
            ]
        ]);
    }
}
