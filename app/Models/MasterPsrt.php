<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPsrt extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak menggunakan nama default (plural dari nama model)
    protected $table = 'master_psrt';

    // Tentukan kolom-kolom yang dapat diisi (fillable)
    protected $fillable = [
        'permintaan_mgng_id',
        'nama_peserta',
        'jenis_kelamin',
        'nik_peserta',
        'nis_peserta',
        'program_studi',
        'no_handphone_peserta',
        'email_peserta',
        'nilai_kedisiplinan',
        'nilai_tanggungjawab',
        'nilai_kerjasama',
        'nilai_motivasi',
        'nilai_kepribadian',
        'nilai_pengetahuan',
        'nilai_pelaksanaankerja',
        'nilai_hasilkerja',
        'nilai_akhir',
        'status_penilaian',
        'scan_penilaian',
        'status_scan_penilaian',
        'catatan',
        'scan_sertifikat',
        'status_sertifikat',
        'id_bdng_member',
    ];

    // Jika tabel memiliki timestamp 'created_at' dan 'updated_at'
    public $timestamps = true;

    public function bdngMember()
    {
        return $this->belongsTo(MasterBdngMember::class, 'id_bdng_member');
    }

    public function masterPsrt()
    {
        return $this->hasMany(MasterPsrt::class, 'permintaan_mgng_id');
    }

    public function permintaan()
{
    return $this->belongsTo(PermintaanMgng::class, 'permintaan_mgng_id');
}
public function notaDinas()
{
    return $this->hasOne(NotaDinas::class, 'permintaan_mgng_id', 'permintaan_mgng_id');
}

}
