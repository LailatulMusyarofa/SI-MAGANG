<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalasanMgng extends Model
{
    protected $table = 'balasan_mgng';

    protected $fillable = [
    'master_mgng_id',
    'nomor_surat_balasan',
    'tanggal_surat_balasan',
    'sifat_surat_balasan',
    'metode_magang',
    'lampiran_surat_balasan',
    'scan_surat_balasan',
    'tanggal_awal_magang',
    'tanggal_akhir_magang',
    'status_surat_balasan',
];

    public function permintaan()
    {
        return $this->belongsTo(PermintaanMgng::class, 'permintaan_mgng_id');
    }

    public function permintaanMgng()
{
    return $this->belongsTo(PermintaanMgng::class, 'master_mgng_id', 'master_mgng_id');
}

    public function master()
    {
        return $this->belongsTo(MasterMgng::class, 'master_mgng_id');
    }

    public function masterMgng()
{
    return $this->belongsTo(MasterMgng::class, 'master_mgng_id', 'id');
}


    
}
