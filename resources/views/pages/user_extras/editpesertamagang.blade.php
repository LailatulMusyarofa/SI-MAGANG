<x-app-layout pageTitle="Edit Peserta Magang">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-arrows breadcrumb-muted">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Beranda</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('user.daftar_permohonan') }}">Daftar Permohonan</a>
                        </li>
                        <li class="breadcrumb-item muted" aria-current="page">
                            Detail Peserta
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">
            <form method="POST" action="{{ route('user.updatepesertamagang', ['id' => $peserta->id]) }}">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Peserta Magang</h3>
                    </div>
                    <div class="card-body">

                        <div class="form-group mb-3">
                            <label for="nama_peserta">Nama Peserta</label>
                            <input type="text" name="nama_peserta" class="form-control @error('nama_peserta') is-invalid @enderror" value="{{ old('nama_peserta', $peserta->nama_peserta) }}" id="nama_peserta" required {{ $permohonan->status_surat_permintaan == 'terkirim' ? 'readonly' : '' }}>
                            @error('nama_peserta') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="nik_peserta">NIK Peserta</label>
                            <input type="number" name="nik_peserta" class="form-control @error('nik_peserta') is-invalid @enderror" value="{{ old('nik_peserta', $peserta->nik_peserta) }}" id="nik_peserta" required {{ $permohonan->status_surat_permintaan == 'terkirim' ? 'readonly' : '' }}>
                            @error('nik_peserta') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="nis_peserta">NIS/NIM Peserta</label>
                            <input type="text" name="nis_peserta" class="form-control @error('nis_peserta') is-invalid @enderror" value="{{ old('nis_peserta', $peserta->nis_peserta) }}" id="nis_peserta" required {{ $permohonan->status_surat_permintaan == 'terkirim' ? 'readonly' : '' }}>
                            @error('nis_peserta') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="program_studi">Program Studi</label>
                            <input type="text" name="program_studi" class="form-control @error('program_studi') is-invalid @enderror" value="{{ old('program_studi', $peserta->program_studi) }}" id="program_studi" required {{ $permohonan->status_surat_permintaan == 'terkirim' ? 'readonly' : '' }}>
                            @error('program_studi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="no_handphone_peserta">Nomor Handphone</label>
                            <input type="number" name="no_handphone_peserta" class="form-control @error('no_handphone_peserta') is-invalid @enderror" value="{{ old('no_handphone_peserta', $peserta->no_handphone_peserta) }}" id="no_handphone_peserta" required {{ $permohonan->status_surat_permintaan == 'terkirim' ? 'readonly' : '' }}>
                            @error('no_handphone_peserta') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="email_peserta">Email Peserta</label>
                            <input type="email" name="email_peserta" class="form-control @error('email_peserta') is-invalid @enderror" value="{{ old('email_peserta', $peserta->email_peserta) }}" id="email_peserta" required {{ $permohonan->status_surat_permintaan == 'terkirim' ? 'readonly' : '' }}>
                            @error('email_peserta') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="form-control @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" id="jenis_kelamin" {{ $permohonan->status_surat_permintaan == 'terkirim' ? 'disabled' : '' }}>
                                <option value="pria" {{ $peserta->jenis_kelamin == 'pria' ? 'selected' : '' }}>Pria</option>
                                <option value="wanita" {{ $peserta->jenis_kelamin == 'wanita' ? 'selected' : '' }}>Wanita</option>
                            </select>
                            @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        @if($permohonan->status_surat_permintaan != 'terkirim')
                            <button type="submit" class="btn btn-primary mt-1">Simpan Perubahan</button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
