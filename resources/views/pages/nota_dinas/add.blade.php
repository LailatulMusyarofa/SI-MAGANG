<x-app-layout pageTitle="Balas Permohonan">
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
                            <a href="{{ route('nota_dinas.proposalselector') }}">Pilih Permohonan</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('nota_dinas.add', $rc->id) }}">Buat Nota Dinas</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">
            <form action="{{ route('nota_dinas.save', ['id' => $rc->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Informasi Dasar</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Nomor Surat Permintaan</td><td>{{ $rc->nomor_surat_permintaan }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Surat Permintaan</td><td>{{ \Carbon\Carbon::parse($rc->tanggal_surat_permintaan)->translatedFormat('d F Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td>File Scan Surat Permintaan</td><td><a href="{{ asset('storage/scan_surat_permintaan/'.$rc->scan_surat_permintaan) }}" target="_blank">Lihat Surat Permintaan</a></td>
                                    </tr>
                                    <tr>
                                        <td>File Scan Proposal Magang</td><td><a href="{{ asset('storage/scan_proposal_magang/'.$rc->scan_proposal_magang) }}" target="_blank">Lihat Proposal</a></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                          <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Daftar Peserta</h3>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nama Peserta</th>
                                            <th>NIS/NIM Peserta</th>
                                            <th>Program Studi</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($rd as $peserta)
                                            <tr>
                                                <td>{{ $peserta->nama_peserta }}</td>
                                                <td>{{ $peserta->nis_peserta }}</td>
                                                <td>{{ $peserta->program_studi }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('nota_dinas.viewpeserta', ['id' => $peserta->id]) }}" class="btn btn-primary btn-sm">
                                                        <span class="mdi mdi-eye"></span> 
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    

                   <div class="col-md-6">
    <div class="card">
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Form untuk Balas Permohonan -->
            <div class="form-group">
                <label for="iNomorNotaDinas"><strong>Nomor Nota Dinas</strong></label>
                <input type="text" name="nomor_nota_dinas" id="iNomorNotaDinas" class="form-control"
                       value="{{ $notaDinas->nomor_nota_dinas ?? '' }}">
            </div><br>

            <div class="form-group">
                <label for="iTanggalNotaDinas"><strong>Tanggal Nota Dinas</strong></label>
                <input type="date" name="tanggal_nota_dinas" id="iTanggalNotaDinas" class="form-control"
                       value="{{ $notaDinas->tanggal_surat_balasan ?? '' }}">
            </div><br>

            <div class="form-group">
                <label for="iSifatNotaDinas"><strong>Sifat Nota Dinas</strong></label>
                <select name="sifat_nota_dinas" id="iSifatNotaDinas" class="form-control">
                    <option value="biasa"  {{ ($notaDinas->sifat_nota_dinas ?? '') == 'biasa' ? 'selected' : '' }}>Biasa</option>
                    <option value="penting" {{ ($notaDinas->sifat_nota_dinas?? '') == 'penting' ? 'selected' : '' }}>Penting</option>
                    <option value="segera" {{ ($notaDinas->sifat_nota_dinas ?? '') == 'segera' ? 'selected' : '' }}>Segera</option>
                </select>
            </div><br>

            <div class="form-group">
                <label for="iLampiranNotaDinas"><strong>Lampiran Surat Balasan</strong></label>
                <select name="lampiran_nota_dinas" id="iLampiranNotaDinas" class="form-control">
                    <option value="tidakada" {{ ($notaDinas->lampiran_nota_dinas ?? '') == 'tidakada' ? 'selected' : '' }}>-</option>
                    <option value="selembar" {{ ($notaDinas->lampiran_nota_dinas ?? '') == 'selembar' ? 'selected' : '' }}>1 (satu) berkas</option>
                </select>
            </div><br>

           <div class="form-group">
    <label for="iMasterBdngId"><strong>Posisi</strong></label>
    <select name="master_bdng_id" id="iMasterBdngId" class="form-control">
        <option value="">-- Pilih Posisi --</option>
        @foreach($bidangOptions as $bdng)
            <option value="{{ $bdng->id }}" {{ old('master_bdng_id', $notaDinas->master_bdng_id ?? '') == $bdng->id ? 'selected' : '' }}>
                {{ $bdng->nama_bidang }}
            </option>
        @endforeach
    </select>
    @error('master_bdng_id')
        <span class="help-block">{{ $message }}</span>
    @enderror
</div><br>

            <!-- Tombol Simpan -->
            <button type="submit" class="btn btn-primary text-white">
                <span class="mdi mdi-content-save"> Simpan</span> 
            </button>

        </div>
    </div>
</div>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>
