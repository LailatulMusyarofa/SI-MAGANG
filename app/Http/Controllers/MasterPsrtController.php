<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterPsrt;
use App\Models\MasterMgng;
use App\Models\MasterSklh;
use App\Models\User;

class MasterPsrtController extends Controller
{
    public function view($id)
{
    // Ambil data peserta berdasarkan ID
    $data = MasterPsrt::findOrFail($id);

    // Kirim data peserta ke view
    return view('pages.master_psrt.view', compact('data'));
}
}
