<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotaDinas extends Model
{
    use HasFactory;

    protected $table = 'nota_dinas';

    protected $fillable = [
        'mgng_id',
        'bdng_id',
        'nomor_nota_dinas',
        'tanggal_nota_dinas',
        'sifat_nota_dinas',
        'lampiran_nota_dinas',
        'scan_nota_dinas',
        'status_nota_dinas',
        'bdng_member_id',
        'scan_laporan_magang',
        'status_laporan',
    ];

    public function permohonan()
    {
        return $this->belongsTo(PermintaanMgng::class, 'master_mgng_id');
    }

    public function bdng()
    {
        return $this->belongsTo(MasterBdng::class, 'master_bdng_id');
    }

    public function mgng()
    {
        return $this->belongsTo(PermintaanMgng::class, 'master_mgng_id');
    }

    public function masterBdng()
{
    return $this->belongsTo(MasterBdng::class, 'master_bdng_id');
}
    public function pejabat()
{
    return $this->belongsTo(MasterBdngMember::class, 'bdng_member_id');
}

public function permintaanMgng()
{
    return $this->belongsTo(PermintaanMgng::class, 'permintaan_mgng_id');
}

}
