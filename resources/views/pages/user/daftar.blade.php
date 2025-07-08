<x-app-layout pageTitle="Daftar User">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                 <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-arrows breadcrumb-muted">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Beranda</a>
                        </li>
                        <li class="breadcrumb-item muted" aria-current="page">
                           Daftar User
                        </li>
                    </ol>
                </nav>
                <div class="col-auto">
                    <h1 class="page-title">Daftar User</h1>
                </div>
                <div class="col-auto ms-auto">
                    <a href="{{ route('user.create') }}" class="btn btn-success">
                        <span class="mdi mdi-plus"> Tambah User</span> 
                    </a>
                </div>
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Alamat E-mail</th>
                                <th>Akses</th>
                                <th>Keterangan</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->fullname ?? $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role->name ?? '-' }}</td>
                                    <td>
                                        @if($user->is_active)
                                            Aktif
                                        @else
                                            Tidak aktif
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('user.show', $user->id) }}" class="btn btn-primary" title="Detail User">
                                            <span class="mdi mdi-eye"></span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Tidak ada data user.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-center">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
