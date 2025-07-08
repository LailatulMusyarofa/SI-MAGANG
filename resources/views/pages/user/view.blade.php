<x-app-layout pageTitle="Lihat Data Pengguna">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
              <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-arrows breadcrumb-muted">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Beranda</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('user.daftar') }}">Daftar User</a>
                        </li>
                        <li class="breadcrumb-item muted" aria-current="page">
                           Lihat User
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <a href="{{ route('user.edit', $user->id) }}" class="btn btn-success">
                        <span class="mdi mdi-pencil"> Edit</span> 
                    </a>

                    <form action="{{ route('user.delete', $user->id) }}" method="POST" class="d-inline-block" 
                          onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <span class="mdi mdi-delete"> Hapus</span> 
                        </button>
                    </form>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-7">
                    <div class="card card-bordered">
                        <div class="card-header">
                            <h3 class="card-title">Lihat Data Pengguna</h3>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-4">Nama</dt>
                                <dd class="col-sm-8">{{ $user->fullname ?? $user->name }}</dd>

                                <dt class="col-sm-4">Username</dt>
                                <dd class="col-sm-8">{{ $user->username ?? $user->username }}</dd>

                                <dt class="col-sm-4">Alamat E-mail</dt>
                                <dd class="col-sm-8">{{ $user->email }}</dd>

                                <dt class="col-sm-4">Hak Akses</dt>
                                <dd class="col-sm-8">{{ $user->role->name ?? '-' }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card card-bordered card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Harap Diperhatikan!</h3>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>Username dan Nama Lengkap harap menggunakan nama asli, bukan nama pena.</li>
                                <li>Pastikan alamat E-mail benar.</li>
                                <li>Password direkomendasikan menggunakan gabungan huruf BESAR/kecil dan angka, misal P455w0rd.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
