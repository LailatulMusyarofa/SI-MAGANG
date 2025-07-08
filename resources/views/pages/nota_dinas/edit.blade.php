<x-app-layout pageTitle="Edit Nota Dinas">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                 <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-arrows breadcrumb-muted">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Beranda</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('nota_dinas.daftar') }}">Nota Dinas Magang</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('nota_dinas.edit', ['id' => $notaDinas->id]) }}">Edit Nota Dinas</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <!-- Kolom Form Input (kiri) -->
                <div class="col-md-6">
                    <form action="{{ route('nota_dinas.update', ['id' => $notaDinas->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card mb-4">
                            <div class="card-body">

                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <div class="form-group mb-3">
                                    <label for="iNomorNotaDinas"><strong>Nomor Nota Dinas</strong></label>
                                    <input type="text" name="nomor_nota_dinas" id="iNomorNotaDinas" class="form-control"
                                           value="{{ old('nomor_nota_dinas', $notaDinas->nomor_nota_dinas) }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="iTanggalNotaDinas"><strong>Tanggal Nota Dinas</strong></label>
                                    <input type="date" name="tanggal_nota_dinas" id="iTanggalNotaDinas" class="form-control"
                                           value="{{ old('tanggal_nota_dinas', \Carbon\Carbon::parse($notaDinas->tanggal_nota_dinas)->format('Y-m-d')) }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="iSifatNotaDinas"><strong>Sifat Nota Dinas</strong></label>
                                    <select name="sifat_nota_dinas" id="iSifatNotaDinas" class="form-control" required>
                                        <option value="biasa" {{ old('sifat_nota_dinas', $notaDinas->sifat_nota_dinas) == 'biasa' ? 'selected' : '' }}>Biasa</option>
                                        <option value="penting" {{ old('sifat_nota_dinas', $notaDinas->sifat_nota_dinas) == 'penting' ? 'selected' : '' }}>Penting</option>
                                        <option value="segera" {{ old('sifat_nota_dinas', $notaDinas->sifat_nota_dinas) == 'segera' ? 'selected' : '' }}>Segera</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="iLampiranNotaDinas"><strong>Lampiran Surat Balasan</strong></label>
                                    <select name="lampiran_nota_dinas" id="iLampiranNotaDinas" class="form-control" required>
                                        <option value="tidakada" {{ old('lampiran_nota_dinas', $notaDinas->lampiran_nota_dinas) == 'tidakada' ? 'selected' : '' }}>-</option>
                                        <option value="selembar" {{ old('lampiran_nota_dinas', $notaDinas->lampiran_nota_dinas) == 'selembar' ? 'selected' : '' }}>1 (satu) berkas</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="iMasterBdngId"><strong>Posisi</strong></label>
                                    <select name="master_bdng_id" id="iMasterBdngId" class="form-control" required>
                                        <option value="">-- Pilih Posisi --</option>
                                        @foreach($bidangOptions as $bdng)
                                            <option value="{{ $bdng->id }}" {{ old('master_bdng_id', $notaDinas->master_bdng_id) == $bdng->id ? 'selected' : '' }}>
                                                {{ $bdng->nama_bidang }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('master_bdng_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="iScanNotaDinas"><strong>Scan Nota Dinas</strong></label>
                                    <input type="file" name="file" id="iScanNotaDinas" class="form-control">
                                    @if($notaDinas->scan_nota_dinas)
                                        <small>File saat ini: <a href="{{ asset('storage/'.$notaDinas->scan_nota_dinas) }}" target="_blank">{{ basename($notaDinas->scan_nota_dinas) }}</a></small>
                                    @endif
                                </div>

                                <div class="form-group mb-3 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="mdi mdi-content-save"> Simpan</span>
                                    </button>
                                    <a href="{{ route('nota_dinas.cetak_pdf', ['id' => $notaDinas->id]) }}" target="_blank" class="btn btn-secondary">
                                        <span class="mdi mdi-printer"> Cetak PDF</span> 
                                    </a>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>

                <!-- Kolom Tabel Peserta (kanan) -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <div class="d-flex justify-content-end mb-3">
                                <a href="{{ route('nota_dinas.additem', ['id' => $notaDinas->id]) }}" class="btn btn-success">
                                    <span class="mdi mdi-plus-thick"> Tambah Peserta</span> 
                                </a>
                            </div>
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-center">DAFTAR PESERTA</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Nama Peserta</th>
                                        <th class="text-center">NIS/NIM</th>
                                        <th class="text-center">Program Studi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($peserta as $p)
                                        <tr>
                                            <td>{{ $p->nama_peserta }}</td>
                                            <td class="text-center">{{ $p->nis_peserta }}</td>
                                            <td>{{ $p->program_studi }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Belum ada peserta.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
