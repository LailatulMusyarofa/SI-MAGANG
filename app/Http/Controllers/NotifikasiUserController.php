<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Menu;
use App\Models\MasterSklh;
use App\Models\PermintaanMgng;
use App\Models\BalasanMgng;
use App\Models\MasterMgng;
use App\Models\MasterPsrt;
use App\Models\NotaDinas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class NotifikasiUserController extends Controller
{
   

// public function daftarPermohonanMasuk(Request $req)
// {   
//     Carbon::setLocale('id');

//     // Ambil data master_sklh berdasarkan user yang login
//     $masterSklh = MasterSklh::where('id_user', Auth::id())->first();

//     if (!$masterSklh) {
//         abort(404, 'Sekolah tidak ditemukan.');
//     }

//     // Ambil data master_mgng berdasarkan master_sklh_id
//     $masterMgng = MasterMgng::where('master_sklh_id', $masterSklh->id)->first();

//     if (!$masterMgng) {
//         abort(404, 'Data master magang belum tersedia.');
//     }

//     // Ambil semua permintaan magang dengan relasi balasan yang status_surat_balasan-nya "terkirim"
//     $permintaan = PermintaanMgng::with('balasan') // Memuat relasi balasan
//         ->where('master_mgng_id', $masterMgng->id)
//         ->whereHas('balasan', function($query) {
//             $query->where('status_surat_balasan', 'terkirim');
//         })
//         ->get();

//     // Ambil data peserta magang jika perlu
//     $data2 = MasterPsrt::all(); 

//     return view('pages.home.index', compact('permintaan', 'data2'));
// }

public function notifikasi()
{

    $userId = Auth::id();

    // Ambil sekolah user
    $masterSklh = MasterSklh::where('id_user', $userId)->first();

    if (!$masterSklh) {
        return response()->json([]);
    }

    // Ambil semua permohonan magang dari sekolah ini
    $permohonan = PermintaanMgng::with('balasan')
        ->whereHas('masterMgng', function ($query) use ($masterSklh) {
            $query->where('master_sklh_id', $masterSklh->id);
        })
        ->latest()
        ->take(10)
        ->get();

    $notifikasi = [];

    foreach ($permohonan as $p) {
        if ($p->balasan && $p->balasan->status_surat_balasan == 'terkirim' && $p->balasan->status_baca_surat_balasan == 'belum') {
            $notifikasi[] = [
                'pesan' => "Balasan untuk permohonan {$p->nomor_surat_permintaan} sudah tersedia.",
                'url' => route('user.detail_permohonanmasuk', $p->id),
                'waktu' => $p->updated_at->diffForHumans()
            ];
        }

        if ($p->status_surat_permintaan == 'ditolak') {
            $notifikasi[] = [
                'pesan' => "Permohonan {$p->nomor_surat_permintaan} ditolak.",
                'url' => route('user.viewpermohonankeluar', $p->id),
                'waktu' => $p->updated_at->diffForHumans()
            ];
        }
    }
    $jumlah = count($notifikasi); 
    // Uncomment if you need the count

    return view('pages.home.fitur.notifikasiUser', compact(
        'notifikasi', 'jumlah'
    )
    )
;}
    }

