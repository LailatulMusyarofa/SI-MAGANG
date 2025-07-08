<x-app-layout pageTitle="Ubah Data Pengguna">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                 
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <a href="{{ route('user.show', $user->id) }}" class="btn btn-secondary mb-3">
                <span class="mdi mdi-arrow-left"> Kembali</span> 
            </a>

            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    {{-- Bagian kiri --}}
                    <div class="col-md-7">
                        <div class="card card-bordered mb-3">
                            <div class="card-header">
                                <h3 class="card-title">Ubah Pengguna</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="fullname" class="form-label">Nama Lengkap</label>
                                    <input type="text" id="fullname" name="fullname" class="form-control" 
                                        value="{{ old('fullname', $user->fullname ?? $user->name) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" id="username" name="username" class="form-control" 
                                        value="{{ old('username', $user->username) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Alamat E-mail</label>
                                    <input type="email" id="email" name="email" class="form-control" 
                                        value="{{ old('email', $user->email) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" id="password" name="password" class="form-control" 
                                        placeholder="Jika tidak diubah, kosongkan">
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Ketik ulang password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" 
                                        placeholder="Ketik ulang apabila ingin dirubah">
                                </div>

                                <div class="mb-3">
                                    <label for="role_id" class="form-label">Hak Akses</label>
                                    <select name="role_id" id="role_id" class="form-select" required>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" 
                                                {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="is_active" class="form-label">Status Pengguna</label>
                                    <select name="is_active" id="is_active" class="form-select" required>
                                        <option value="1" {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Perbarui</button>
                            </div>
                        </div>
                    </div>

                    {{-- Bagian kanan --}}
                    <div class="col-md-5">
                        <div class="card card-bordered card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Harap diperhatikan!</h3>
                            </div>
                            <div class="card-body">
                                <ul>
                                    <li>Nama pengguna harap menggunakan nama asli, bukan nama pena.</li>
                                    <li>Pastikan alamat E-mail benar.</li>
                                    <li>Password direkomendasikan menggunakan gabungan huruf BESAR/kecil dan angka, misal P455w0rd.</li>
                                    <li>Foto profil tidak boleh mengandung unsur SARA/Pornografi.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
