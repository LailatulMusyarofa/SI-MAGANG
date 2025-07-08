<x-app-layout pageTitle="Tambah Peserta">
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
                    <li class="breadcrumb-item">
                            <a href="{{ route('user.viewpermohonankeluar', ['id' => $permohonan->id]) }}">Detail Permohonan</a>
                    </li>
                    <li class="breadcrumb-item muted" aria-current="page">
                    Tambah Peserta
                    </li>
                </ol>
                </nav>
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">

            {{-- Notifikasi --}}
            @if (session('result') == 'success')
                <div class="alert alert-success">
                    Data berhasil disimpan.
                </div>
            @endif

            {{-- Form hanya muncul jika akun diverifikasi dan permohonan belum terkirim --}}
            @if(Auth::user()->akun_diverifikasi == 'sudah')
                @if($permohonan->status_surat_permintaan == 'belum')

                    {{-- Form Tambah Peserta --}}
                    <form action="{{ route('user.simpanpeserta', ['id' => $permohonan->id]) }}" method="POST">
                    @csrf
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title mb-0">Tambah Peserta</h3>
                                <button type="submit" class="btn btn-primary">
                                    <span class="mdi mdi-content-save"> Simpan</span>
                                </button>
                            </div>

                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-md-6">

                                        <div class="mb-3">
                                            <label for="iNamaPeserta">Nama Peserta</label>
                                            <input type="text" name="nama_peserta" class="form-control {{ $errors->has('nama_peserta') ? 'is-invalid' : '' }}" value="{{ old('nama_peserta') }}" id="iNamaPeserta" placeholder="contoh : Hyuuga Uzuki" required>
                                            @error('nama_peserta')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="iJenisKelamin" class="form-label">Jenis Kelamin</label>
                                            <select name="jenis_kelamin"
                                                    id="iJenisKelamin"
                                                    class="form-select {{ $errors->has('jenis_kelamin') ? 'is-invalid' : '' }}"
                                                    required>
                                                <option value="Pria" {{ old('jenis_kelamin', $dt->jenis_kelamin ?? '') == 'Pria' ? 'selected' : '' }}>Pria</option>
                                                <option value="Wanita" {{ old('jenis_kelamin', $dt->jenis_kelamin ?? '') == 'Wanita' ? 'selected' : '' }}>Wanita</option>
                                            </select>
                                            @error('jenis_kelamin')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="iNikPeserta">NIK Peserta</label>
                                            <input type="number" name="nik_peserta" class="form-control {{ $errors->has('nik_peserta') ? 'is-invalid' : '' }}" value="{{ old('nik_peserta') }}" id="iNikPeserta" placeholder="contoh : 0123456789123456" required>
                                            @error('nik_peserta')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="iNisPeserta">NIS/NIM Peserta</label>
                                            <input type="text" name="nis_peserta" class="form-control {{ $errors->has('nis_peserta') ? 'is-invalid' : '' }}" value="{{ old('nis_peserta') }}" id="iNisPeserta" placeholder="contoh : 1234567891" required>
                                            @error('nis_peserta')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="iProgramStudi">Program Studi</label>
                                            <input type="text" name="program_studi" class="form-control {{ $errors->has('program_studi') ? 'is-invalid' : '' }}" value="{{ old('program_studi') }}" id="iProgramStudi" placeholder="contoh : Teknik Mesin" required>
                                            @error('program_studi')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="iNomorHandphone">Nomor Handphone</label>
                                            <input type="number" name="no_handphone_peserta" class="form-control {{ $errors->has('no_handphone_peserta') ? 'is-invalid' : '' }}" value="{{ old('no_handphone_peserta') }}" id="iNomorHandphone" placeholder="contoh : 0812345678910" required>
                                            @error('no_handphone_peserta')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="iEmailPeserta">Email Peserta</label>
                                            <input type="email" name="email_peserta" class="form-control {{ $errors->has('email_peserta') ? 'is-invalid' : '' }}" value="{{ old('email_peserta') }}" id="iEmailPeserta" placeholder="contoh : peserta@email.com" required>
                                            @error('email_peserta')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                @else
                    {{-- Jika permohonan sudah terkirim --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-danger mb-3">
                                <div class="card-header">
                                    <h3 class="card-title">Akses Ditolak!</h3>
                                </div>
                                <div class="card-body">
                                    Tidak dapat menambahkan peserta ke permohonan yang sudah terkirim.
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

        </div>
    </div>
</x-app-layout>
