<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class CetakDashboardController extends Controller
{
    public function print()
    {
        // pendaftar yang mengajukan magang
        $pendaftar = DB::table('administrasis')
            ->where('status_pengajuan', 'diterima')
            ->count();

        // Permohonan magang yang belum disetujui
        $pending = DB::table('administrasis')
            ->where('status_pengajuan', 'belum diproses')
            ->count();

        // Jumlah peserta yang sudah selesai magang
        $totalSelesai = DB::table('master_psrt')
            ->where('status_sertifikat', 'terkirim')
            ->count();
        
        // Jumlah peserta yang masih aktif (belum terkirim sertifikatnya)
        $Aktif = DB::table('master_psrt')
            ->where(function ($query) {
                $query->where('status_sertifikat', '!=', 'terkirim')
                      ->orWhereNull('status_sertifikat');
            })
            ->count();
        // Persentase selesai
        $persentase = $totalSelesai > 0 ? 
            round(
                ($totalSelesai / ($totalSelesai + $Aktif)) * 100
                ) : 0;

        // Jumlah peserta yang sudah scan sertifikat
        $pesertaAktif = DB::table('master_psrt')
            ->where('status_sertifikat', 'belum')
            ->count();
        // Jumlah peserta yang sudah diverifikasi berkasnya
        $verifikasiBerkasAktif = DB::table('balasan_mgng')
        ->where(function ($query) {
        $query->whereNull('scan_surat_balasan')
              ->orWhere('scan_surat_balasan', '');
        })
        ->count();
        // Jumlah peserta yang sudah persetujuan pimpinan
        $persetujuanPimpinanAktif = DB::table('balasan_mgng')
            ->where('status_surat_balasan', 'belum')
            ->count();
        // Jumlah peserta yang sudah proses magang
        $prosesMagangAktif = DB::table('master_psrt')
        ->where(function($q) {
            $q->whereNull('scan_sertifikat')
            ->orWhere('scan_sertifikat', '');
        })
        ->count();
        // Jumlah peserta yang sudah evaluasi
        $evaluasiAktif = DB::table('master_psrt')
            ->where('status_penilaian', 'belum')
            ->count();
        // Jumlah peserta yang sudah sertifikat
         $sertifikatAktif = DB::table('master_psrt')
            ->where('status_sertifikat', 'belum')
            ->count();


        // Jumlah peserta yang sudah selesai magang
        $pesertaSelesai = DB::table('master_psrt')
            ->where('status_sertifikat', 'terkirim')
            ->count();
        // Jumlah peserta yang sudah diverifikasi berkasnya
        $verifikasiBerkasSelesai = DB::table('balasan_mgng')
        ->whereNotNull('scan_surat_balasan')
        ->where('scan_surat_balasan', '!=', '')
        ->count();
        // Jumlah peserta yang sudah persetujuan pimpinan
        $persetujuanPimpinanSelesai = DB::table('balasan_mgng')
            ->where('status_surat_balasan', 'terkirim')
            ->count();
        // Jumlah peserta yang sudah proses magang
        $prosesMagangSelesai = DB::table('master_psrt')
        ->whereNotNull('scan_sertifikat')
        ->where('scan_sertifikat', '!=', '')
        ->count();
        // Jumlah peserta yang sudah evaluasi
         $evaluasiSelesai = DB::table('master_psrt')
            ->where('status_penilaian', 'sudah')
            ->count();
        // Jumlah peserta yang sudah sertifikat
        $sertifikatSelesai = DB::table('master_psrt')
            ->where('status_sertifikat', 'terkirim')
            ->count();

       // Data untuk dikirim ke view PDF
        $data = [
            'tanggal' => now()->translatedFormat('d F Y'),
            'pendaftar' => $pendaftar,
            'pending' => $pending,
            'aktif' => $Aktif,
            'lulus' => $totalSelesai,
            'persentase' => $persentase,
            'peserta' => $pesertaAktif,
            'verifikasiBerkas' => $verifikasiBerkasAktif,
            'persetujuanPimpinan' => $persetujuanPimpinanAktif,
            'prosesMagang' => $prosesMagangAktif,
            'evaluasi' => $evaluasiAktif,
            'sertifikat' => $sertifikatAktif,
            'pesertaSelesai' => $pesertaSelesai,
            'verifikasiBerkasSelesai' => $verifikasiBerkasSelesai,
            'persetujuanPimpinanSelesai' => $persetujuanPimpinanSelesai,
            'prosesMagangSelesai' => $prosesMagangSelesai,
            'evaluasiSelesai' => $evaluasiSelesai,
            'sertifikatSelesai' => $sertifikatSelesai,

        ];

        $pdf = Pdf::loadView('pages.home.fitur.cetakRingkasanDashboard', $data)->setPaper('a4', 'portrait');
        return $pdf->stream('ringkasan-dashboard-magang.pdf'); // langsung preview di browser
        // return $pdf->download('ringkasan-dashboard-magang.pdf'); // kalau mau langsung download
    }
}
