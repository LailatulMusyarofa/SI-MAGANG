<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{   
    public function setting()
{
    return view('pages.user.setting');
}

public function updateSetting(Request $request)
{
    // Temukan user berdasarkan ID
    $user = Auth::user();

    // Validasi input
    $rules = [
        'fullname' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|confirmed|min:8',
    ];

    $validated = $request->validate($rules);

    // Update data user
    $user->fullname = $validated['fullname'];
    $user->username = $validated['username'];
    $user->email = $validated['email'];

    // Update password jika ada
    if (!empty($validated['password'])) {
        $user->password = Hash::make($validated['password']);
    }

    $user->save();  // Simpan perubahan

    // Redirect ke halaman pengaturan akun dengan pesan sukses
    return redirect()->route('user.setting')->with('success', 'Pengaturan akun berhasil diperbarui.');
}


public function daftar(Request $request)
{
    $users = User::with('role')->paginate(10);

    return view('pages.user.daftar', compact('users'));
}

public function show($id)
{
    $user = User::with('role')->findOrFail($id);

    return view('pages.user.view', compact('user'));
}
public function edit($id)
{
    $user = User::findOrFail($id);
    $roles = Role::all(); 

    return view('pages.user.edit', compact('user', 'roles'));
}

public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $rules = [
        'fullname' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|confirmed|min:8',
        'role_id' => 'required|exists:roles,id',
        'is_active' => 'required|boolean',  
    ];

    $validated = $request->validate($rules);

    $user->fullname = $validated['fullname'];
    $user->username = $validated['username'];
    $user->email = $validated['email'];
    $user->role_id = $validated['role_id'];
    $user->is_active = $validated['is_active'];  

    if (!empty($validated['password'])) {
        $user->password = Hash::make($validated['password']);
    }

    $user->save();

    return redirect()->route('user.show', $user->id)->with('success', 'Data pengguna berhasil diperbarui.');
}


public function create()
{
    $roles = Role::all();

    return view('pages.user.add', compact('roles'));
}

public function store(Request $request)
{
    $rules = [
        'fullname' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username',
        'email' => 'required|email|max:255|unique:users,email',
        'password' => 'required|confirmed|min:8',
        'role_id' => 'required|exists:roles,id',
        'is_active' => 'required|boolean', 
    ];

    $validated = $request->validate($rules);

    $user = new User();
    $user->fullname = $validated['fullname'];
    $user->username = $validated['username'];  
    $user->email = $validated['email'];
    $user->password = Hash::make($validated['password']);
    $user->role_id = $validated['role_id'];
    $user->is_active = $validated['is_active'];  

    $user->save();

    return redirect()->route('user.daftar')->with('success', 'Pengguna baru berhasil ditambahkan.');
}

}