<x-app-layout pageTitle="Pengaturan Akun">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <x-breadcrumb pageTitle="Pengaturan Akun" />
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user.setting.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="fullname" class="form-label">Nama Lengkap</label>
                    <input type="text" id="fullname" name="fullname" class="form-control" value="{{ old('fullname', auth()->user()->fullname) }}" required>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" value="{{ old('username', auth()->user()->username) }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Alamat E-mail</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Jika tidak diubah, kosongkan">
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Ketik ulang password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Ketik ulang apabila ingin dirubah">
                </div>

                <button type="submit" class="btn btn-primary">Simpan perubahan</button>
                @if(auth()->user()->role_id == 1)
                    <a href="{{ route('user.daftar') }}" class="btn btn-secondary ms-1">
                        Kelola akun lainnya
                    </a>
                @endif
            </form>

        </div>
    </div>
</x-app-layout>
