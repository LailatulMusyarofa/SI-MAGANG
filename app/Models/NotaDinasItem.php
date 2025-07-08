<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NotaDinasItem extends Model
{
    use HasFactory;

    protected $table = 'nota_dinas_item';

    protected $fillable = [
        'nota_dinas_id',
        'master_psrt_id',
    ];

    public function notaDinas()
    {
        return $this->belongsTo(NotaDinas::class, 'nota_dinas_id');
    }

    public function psrt()
    {
        return $this->belongsTo(MasterPsrt::class, 'master_psrt_id');  // Perbaiki nama kolom
    }
}
