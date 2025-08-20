<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CetakDashboardController extends Controller
{
    public function print()
    {
        // data dari database bisa dimasukkan di sini
        $data = [
            'tanggal' => now()->translatedFormat('d F Y'),
            'pendaftar' => 200,
            'pending' => 13,
            'aktif' => 17,
            'lulus' => 134,
            'persentase' => 88,
        ];

        $pdf = Pdf::loadView('pages.home.fitur.cetakRingkasanDashboard', $data)->setPaper('a4', 'portrait');
        return $pdf->stream('ringkasan-dashboard-magang.pdf'); // langsung preview di browser
        // return $pdf->download('ringkasan-dashboard-magang.pdf'); // kalau mau langsung download
    }
}
