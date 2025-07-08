<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $userArray1 = [
        'role_id' => 1,
        'fullname' => 'Skibidi Bidi',
        'username' => 'skibidi',
        'email' => 'skibidi@mail.com',
        'password' => Hash::make('skibidi'),
        'is_active' => true,
        'email_verified_at' => Carbon::now(),
    ];

    $userArray2 = [
        'role_id' => 2,
        'fullname' => 'UPN Veteran Jawa Timur',
        'username' => 'upnvjt',
        'email' => 'test@mail.com',
        'password' => Hash::make('test'),
        'is_active' => true,
        'email_verified_at' => Carbon::now(),
    ];

    User::create($userArray1);
    User::create($userArray2);
}

}
