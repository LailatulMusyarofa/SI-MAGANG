<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterBdng extends Model
{
    protected $table = 'master_bdng';

    public function notaDinas()
    {
        return $this->hasMany(NotaDinas::class, 'bdng_id', 'id');
    }

    
}
