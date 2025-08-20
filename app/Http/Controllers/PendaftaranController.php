<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PendaftaranController extends Controller
{
    public function index()
    {
        return view('pages.home.fitur.pendaftaran');
    }

    public function grafik($tahun)
    {
        // Validasi input tahun (maksimal 2100 dan minimal 2000)
        if (!is_numeric($tahun) || $tahun < 2000 || $tahun > 2100) {
            return response()->json([
                'error' => 'Tahun tidak valid'
            ], 400);
        }

        $pendaftarPerBulan = [];
        $diterimaPerBulan = [];
        $labelBulan = [];

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $pendaftarPerBulan[] = DB::table('master_psrt')
                ->whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan)
                ->count();

            $diterimaPerBulan[] = DB::table('master_psrt')
                ->whereYear('created_at', $tahun)
                ->whereMonth('created_at', $bulan)
                ->where('status_sertifikat', 'terkirim')
                ->count();

            $labelBulan[] = Carbon::createFromDate($tahun, $bulan, 1)->format('Y-m');
        }

        return response()->json([
            'labels' => $labelBulan,
            'pendaftar' => $pendaftarPerBulan,
            'diterima' => $diterimaPerBulan
        ]);
    }
}
