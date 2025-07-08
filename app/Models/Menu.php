<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'icon', 'url', 'order', 'is_active', 'parent_id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function getMenuIdByUrl($url)
    {
        return $this->where('url', $url)->first()->id ?? null;
    }

    public function getMenuIdLikeUrl($url)
    {
        return $this->where('url', 'like', "%$url%")->first()->id ?? null;
    }

    public function getParentNameById($id)
    {
        return $this->where('id', $id)->first()->name;
    }

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public function menuRolePermissions()
    {
        return $this->hasMany(MenuRolePermission::class);
    }
}
