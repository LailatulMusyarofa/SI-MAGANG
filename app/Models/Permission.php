<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function getPermissionCodeByActionName($actionName)
    {
        return $this->where('action_name', 'LIKE', "%$actionName%")->value('code') ?? null;
    }

    public function getPermissionHttpMethodByActionName($actionName)
    {
        return $this->where('action_name', 'LIKE', "%$actionName%")->value('http_method') ?? null;
    }

    public function menuRolePermissions()
    {
        return $this->hasMany(MenuRolePermission::class);
    }
}
