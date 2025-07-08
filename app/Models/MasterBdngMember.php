<?php

namespace App\Models;

use App\Models\MasterBdng;
use Illuminate\Database\Eloquent\Model;


class MasterBdngMember extends Model
{
    protected $table = 'master_bdng_member';

    protected $fillable = [
        'nama_pejabat',
        'nip_pejabat',
        'pangkat_pejabat',
        'golongan_pejabat',
        'ruang_pejabat',
        'jabatan_pejabat',
        'sub_bidang_pejabat',
        'id_bdng',
    ];

    public function bidang()
    {
        return $this->belongsTo(MasterBdng::class, 'id_bdng');
    }

    public function masterBdng()
    {
        return $this->belongsTo(MasterBdng::class, 'id_bdng');
    }
}
