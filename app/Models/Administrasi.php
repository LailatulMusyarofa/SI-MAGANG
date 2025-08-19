<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrasi extends Model
{
    use HasFactory;

    protected $table = 'administrasis';

    protected $fillable = [
        'nama_lembaga',
        'alamat',
        'kontak',
        'narahubung',
        'jenis_kelamin',
        'jabatan',
        'no_hp',
        'status_pengajuan',
        
    ];

}
