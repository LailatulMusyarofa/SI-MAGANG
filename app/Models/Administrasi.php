<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administrasi extends Model
{
    protected $fillable = ['nama', 'status', 'keterangan']; // sesuaikan dengan kolom di tabel
}
