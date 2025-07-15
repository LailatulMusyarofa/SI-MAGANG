<x-app-layout pageTitle="Edit Data Administrasi">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-arrows breadcrumb-muted">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Beranda</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('master_administrasi') }}">Daftar Administrasi</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Edit Administrasi
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-header mb-3">
                <h1 class="card-title h1">EDIT DATA ADMINISTRASI</h1>
            </div>

            <div class="card">
                <div class="card-body">
                    <form action="{{ route('master_administrasi.update', $administrasi->id) }}" method="POST" class="row g-3">
                        @csrf
                        @method('PUT')

                        <div class="col-12 col-md-6">
                            <label class="form-label">Nama Lembaga</label>
                            <input type="text" name="lembaga" class="form-control" value="{{ old('lembaga', $administrasi->lembaga) }}" required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $administrasi->alamat) }}" required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">Narahubung</label>
                            <input type="text" name="narahubung" class="form-control" value="{{ old('narahubung', $administrasi->narahubung) }}" required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">Status Administrasi</label>
                            <select name="status" class="form-select" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="proses" {{ old('status', $administrasi->status) == 'proses' ? 'selected' : '' }}>Proses</option>
                                <option value="sukses" {{ old('status', $administrasi->status) == 'sukses' ? 'selected' : '' }}>Sukses</option>
                            </select>
                        </div>

                        <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('master_administrasi') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
