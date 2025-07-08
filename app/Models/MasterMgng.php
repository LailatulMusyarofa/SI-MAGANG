<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterMgng extends Model
{
    use HasFactory;

    protected $table = 'master_mgng';

    protected $fillable = [
        'master_sklh_id',
    ];

    public function masterSklh()
    {
        return $this->belongsTo(MasterSklh::class, 'master_sklh_id');
    }

    public function permintaan()
    {
        return $this->hasOne(PermintaanMgng::class, 'master_mgng_id');
    }

    public function balasan()
    {
        return $this->hasOne(BalasanMgng::class, 'master_mgng_id');
    }

    public function peserta()
{
    return $this->hasMany(MasterPsrt::class, 'master_mgng_id');
}

}