<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSklh extends Model
{   

    use HasFactory;

    protected $table = 'master_sklh'; // Nama tabel yang digunakan
    protected $primaryKey = 'id'; // Jika id bukan primary key, sesuaikan
    public $timestamps = true; // Sesuaikan jika tidak menggunakan kolom created_at dan updated_at

    protected $fillable = [
        'id_user',
        'jenis_sklh',
        'alamat_sklh',
        'kabko_sklh',
        'telp_sklh',
        'akreditasi_sklh',
        'no_akreditasi_sklh',
        'scan_surat_akreditasi_sklh',
        'nama_narahubung',
        'jenis_kelamin_narahubung',
        'jabatan_narahubung',
        'handphone_narahubung',
    ];

    public function user()
{
    return $this->belongsTo(User::class, 'id_user'); 
}
    public function masterMgng()
{
    return $this->hasOne(MasterMgng::class, 'master_sklh_id');
}
}
