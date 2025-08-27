<?php

namespace App\Http\Controllers;

use App\Models\NotifikasiUser as ModelsNotifikasiUser;
use App\Notifications\NotifikasiUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiUserController extends Controller

{
    public function index()
    {
        // ambil 5 notifikasi terbaru
        $notifs = ModelsNotifikasiUser::latest()->take(5)->get();

        return view('pages.index', compact('notifs'));
    }
}
