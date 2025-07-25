<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class GrafikStatusController extends Controller

{
    public function chartData()
    {
        // --- Data selesai
        $pesertaSelesai = DB::table('master_psrt')
            ->where('status_sertifikat', 'terkirim')
            ->count();

       $verifikasiBerkasSelesai = DB::table('balasan_mgng')
        ->whereNotNull('scan_surat_balasan')
        ->where('scan_surat_balasan', '!=', '')
        ->count();

        $persetujuanPimpinanSelesai = DB::table('balasan_mgng')
            ->where('status_surat_balasan', 'terkirim')
            ->count();

        $prosesMagangSelesai = DB::table('master_psrt')
        ->whereNotNull('scan_sertifikat')
        ->where('scan_sertifikat', '!=', '')
        ->count();

        $evaluasiSelesai = DB::table('master_psrt')
            ->where('status_penilaian', 'sudah')
            ->count();

        $sertifikatSelesai = DB::table('master_psrt')
            ->where('status_sertifikat', 'terkirim')
            ->count();

        // --- Data aktif / masih proses
        $pesertaAktif = DB::table('master_psrt')
            ->where('status_sertifikat', 'belum')
            ->count();

        $verifikasiBerkasAktif = DB::table('balasan_mgng')
        ->where(function ($query) {
        $query->whereNull('scan_surat_balasan')
              ->orWhere('scan_surat_balasan', '');
        })
        ->count();

        $persetujuanPimpinanAktif = DB::table('balasan_mgng')
            ->where('status_surat_balasan', 'belum')
            ->count();

        $prosesMagangAktif = DB::table('master_psrt')
        ->where(function($q) {
            $q->whereNull('scan_sertifikat')
            ->orWhere('scan_sertifikat', '');
        })
        ->count();

        $evaluasiAktif = DB::table('master_psrt')
            ->where('status_penilaian', 'belum')
            ->count();

        $sertifikatAktif = DB::table('master_psrt')
            ->where('status_sertifikat', 'belum')
            ->count();

        return response()->json([
            'categories' => ['Peserta', 'Verifikasi Berkas', 'Persetujuan Pimpinan','Proses Magang', 'Evaluasi', 'Sertifikat'],
            'series' => [
                [
                    'name' => 'Masih Aktif',
                    'data' => [
                        $pesertaAktif,
                        $verifikasiBerkasAktif,
                        $persetujuanPimpinanAktif,
                        $prosesMagangAktif,
                        $evaluasiAktif,
                        $sertifikatAktif
                    ]
                ],  
                [
                    'name' => 'Selesai',
                    'data' => [
                        $pesertaSelesai,
                        $verifikasiBerkasSelesai,
                        $persetujuanPimpinanSelesai,
                        $prosesMagangSelesai,
                        $evaluasiSelesai,
                        $sertifikatSelesai
                    ]
                ]
            ]
        ]);
    }
}


