<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministrasiController extends Controller
{
    public function master()
{
    $data = [
        [
            'lembaga' => 'Institut Teknologi Sepuluh Nopember',
            'alamat' => 'Kota Surabaya<br>(031) 5994251<br>its@gmail.com',
            'narahubung' => 'Nabil Ishfaqqq<br>Pria<br>Koor Prodi<br>12345678',
            'status' => 'proses'
        ],
        [
            'lembaga' => 'Institut Teknologi Sepuluh Nopember',
            'alamat' => 'Kota Surabaya<br>(031) 5994251<br>its@gmail.com',
            'narahubung' => 'Nabil Ishfaqqq<br>Pria<br>Koor Prodi<br>12345678',
            'status' => 'sukses'
        ],
    ];


    return view('pages.master_administrasi.administrasi', compact('data'));
}

    
}
