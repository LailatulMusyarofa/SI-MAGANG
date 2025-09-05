<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CardStatikController extends Controller
{
    public function index()
    {
        $tahunIni = Carbon::now()->year;
        $bulanIni = Carbon::now()->month;

        $permohonanDitangani = DB::table('administrasis')
            ->where('status_pengajuan', 'diterima')
            ->whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->count();

        $permohonanPending = DB::table('administrasis')
            ->where('status_pengajuan', 'belum diproses')
            ->whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->count();

        $magangAktif = DB::table('master_psrt')
            ->where(function ($query) {
                $query->where('status_sertifikat', '!=', 'terkirim')
                    ->orWhereNull('status_sertifikat');
            })
            ->whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->count();

        $lulusBulanIni = DB::table('master_psrt')
            ->where('status_sertifikat', 'terkirim')
            ->whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->count();



        return view('pages.home.fitur.index', compact(
            'permohonanDitangani',
            'permohonanPending',
            'magangAktif',
            'lulusBulanIni'
        ));
    }
}
