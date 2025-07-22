<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Menu;
use App\Models\MenuRolePermission;
use App\Models\Permission;

if (!function_exists('statusClass')) {
    function statusClass($status) {
        return match($status) {
            'sukses' => 'dot-success',
            'proses' => 'dot-warning',
            'belum' => 'dot-danger',
            default => '',
        };
    }
}
