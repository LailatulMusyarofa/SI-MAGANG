<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;


class NotifikasiUser extends Model

{
    use HasFactory;

    protected $table = 'notifikasi_users'; // pastikan sama dengan nama tabelmu
    protected $fillable = ['status_baca_surat_balasan', 'status_surat_balasan'];

    // accessor untuk time_ago
    public function getTimeAgoAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }
}


