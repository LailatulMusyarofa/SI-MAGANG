<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class NotifikasiUser extends Model

{
    protected $table = 'balasan_mgng'; // contoh pakai tabel balasan
    protected $guarded = [];

    // Format waktu "2 minggu lalu"
    public function getTimeAgoAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }
}


