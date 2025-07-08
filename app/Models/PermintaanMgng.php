<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanMgng extends Model
{
    protected $table = 'permintaan_mgng';

    protected $fillable = [
        'master_mgng_id',
        'nomor_surat_permintaan',
        'tanggal_surat_permintaan',
        'perihal_surat_permintaan',
        'ditandatangani_oleh',
        'scan_surat_permintaan',
        'scan_proposal_magang',
        'status_surat_permintaan',
        'status_baca_surat_permintaan',
];
public function masterMgng()
{
    return $this->belongsTo(MasterMgng::class, 'master_mgng_id',);
}

public function balasan()
{
    return $this->hasOne(BalasanMgng::class, 'master_mgng_id', 'master_mgng_id');
}

public function peserta()
    {
        return $this->hasMany(MasterPsrt::class, 'permintaan_mgng_id');
    }

// public function notaDinas()
// {
//     return $this->hasOne(NotaDinas::class, 'master_mgng_id', 'master_mgng_id');
// }

public function notaDinas()
{
    return $this->hasOne(NotaDinas::class, 'permintaan_mgng_id', 'id');
}

public function balasan2()
{
    return $this->hasOne(BalasanMgng::class, 'permintaan_mgng_id');
}
}
