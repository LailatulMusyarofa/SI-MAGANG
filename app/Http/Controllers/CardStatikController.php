<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CardStatikController extends Controller
{
    public function chartData()
    {
        $tahunIni = Carbon::now()->year;
        $tahunLalu = $tahunIni - 1;

        // Ambil data per tahun
        $data = function ($tahun) {
            return [
                'aktif' => DB::table('master_psrt')
                    ->where('status_sertifikat', 'belum')
                    ->whereYear('created_at', $tahun)
                    ->count(),

                'lulus' => DB::table('master_psrt')
                    ->where('status_sertifikat', 'terkirim')
                    ->whereYear('created_at', $tahun)
                    ->count()
            ];
        };

        $dataTahunIni = $data($tahunIni);
        $dataTahunLalu = $data($tahunLalu);

        // Fungsi persentase pertumbuhan
        $persentase = function ($now, $last) {
            if ($last == 0) return $now > 0 ? 100 : 0;
            return round((($now - $last) / $last) * 100, 2);
        };

        // Fungsi label arah
        $withLabel = function ($val) {
            return ($val >= 0 ? "↗ " : "↘ ") . abs($val) . "% dari tahun lalu";
        };

        return response()->json([
            'data' => [
                'aktif' => [
                    'jumlah' => $dataTahunIni['aktif'],
                    'persentase' => $persentase($dataTahunIni['aktif'], $dataTahunLalu['aktif']),
                    'label' => $withLabel($persentase($dataTahunIni['aktif'], $dataTahunLalu['aktif']))
                ],
                'lulus' => [
                    'jumlah' => $dataTahunIni['lulus'],
                    'persentase' => $persentase($dataTahunIni['lulus'], $dataTahunLalu['lulus']),
                    'label' => $withLabel($persentase($dataTahunIni['lulus'], $dataTahunLalu['lulus']))
                ],
                'total_aktif_tahun_ini' => $dataTahunIni['aktif']
            ]
        ]);
    }
}
