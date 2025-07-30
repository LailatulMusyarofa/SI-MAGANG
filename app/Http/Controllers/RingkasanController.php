<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RingkasanController extends Controller
{
    public function ringkasan()
    {
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

        return view('pages.home.index', compact('ringkasan'));
    }
}
