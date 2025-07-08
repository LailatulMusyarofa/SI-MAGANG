<x-app-layout pageTitle="Balas Permohonan">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-arrows breadcrumb-muted">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('proposal_masuk') }}">Daftar Permohonan Magang</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('proposal_masuk.balaspermohonan', ['id' => $rc->id]) }}">Balas Permohonan</a>
                    </ol>
                </nav>
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">
            <form action="{{ route('proposal_masuk.tanggapiproposal', ['id' => $rc->id]) }}" method="POST" enctype="multipart/form-data">
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
                                        <td>File Scan Surat Permintaan</td>
                                        <td>
                                            <a href="{{ asset('storage/' . $rc->scan_surat_permintaan) }}" target="_blank">Lihat Surat Permintaan</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>File Scan Proposal Magang</td>
                                        <td>
                                            <a href="{{ asset('storage/' . $rc->scan_proposal_magang) }}" target="_blank">Lihat Proposal</a>
                                        </td>
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
                                        @foreach($rd as $dt)
                                            <tr>
                                                <td>{{ $dt->nama_peserta }}</td>
                                                <td>{{ $dt->nis_peserta }}</td>
                                                <td>{{ $dt->program_studi }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('proposal_masuk.viewpeserta', ['id' => $dt->id]) }}" class="btn btn-primary">
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
                <label for="iNomorSuratBalasan"><strong>Nomor Surat Balasan</strong></label>
                <input type="text" name="nomor_surat_balasan" id="iNomorSuratBalasan" class="form-control"
                       value="{{ $balasan->nomor_surat_balasan ?? '' }}">
            </div><br>

            <div class="form-group">
                <label for="iTanggalSuratBalasan"><strong>Tanggal Surat</strong></label>
                <input type="date" name="tanggal_surat_balasan" id="iTanggalSuratBalasan" class="form-control"
                       value="{{ $balasan->tanggal_surat_balasan ?? '' }}">
            </div><br>

            <div class="form-group">
                <label for="iSifatSuratBalasan"><strong>Sifat</strong></label>
                <select name="sifat_surat_balasan" id="iSifatSuratBalasan" class="form-control">
                    <option value="biasa"  {{ ($balasan->sifat_surat_balasan ?? '') == 'biasa' ? 'selected' : '' }}>Biasa</option>
                    <option value="penting" {{ ($balasan->sifat_surat_balasan ?? '') == 'penting' ? 'selected' : '' }}>Penting</option>
                    <option value="segera" {{ ($balasan->sifat_surat_balasan ?? '') == 'segera' ? 'selected' : '' }}>Segera</option>
                </select>
            </div><br>

            <div class="form-group">
                <label for="iMetodeMagang"><strong>Metode Magang</strong></label>
                <select name="metode_magang" id="iMetodeMagang" class="form-control">
                    <option value="offline" {{ ($balasan->metode_magang ?? '') == 'offline' ? 'selected' : '' }}>Offline</option>
                    <option value="online"  {{ ($balasan->metode_magang ?? '') == 'online'  ? 'selected' : '' }}>Online</option>
                </select>
            </div><br>

            <div class="form-group">
                <label for="iLampiranSuratBalasan"><strong>Lampiran Surat Balasan</strong></label>
                <select name="lampiran_surat_balasan" id="iLampiranSuratBalasan" class="form-control">
                    <option value="tidakada" {{ ($balasan->lampiran_surat_balasan ?? '') == 'tidakada' ? 'selected' : '' }}>-</option>
                    <option value="selembar" {{ ($balasan->lampiran_surat_balasan ?? '') == 'selembar' ? 'selected' : '' }}>1 (satu) berkas</option>
                </select>
            </div><br>

            <div class="form-group">
                <label for="iTanggalAwalMagang"><strong>Tanggal Awal Magang</strong></label>
                <input type="date" name="tanggal_awal_magang" id="iTanggalAwalMagang" class="form-control"
                       value="{{ $balasan->tanggal_awal_magang ?? '' }}">
            </div><br>

            <div class="form-group">
                <label for="iTanggalAkhirMagang"><strong>Tanggal Akhir Magang</strong></label>
                <input type="date" name="tanggal_akhir_magang" id="iTanggalAkhirMagang" class="form-control"
                       value="{{ $balasan->tanggal_akhir_magang ?? '' }}">
            </div><br>

            @if(isset($balasan) && is_null($balasan->scan_surat_balasan))
                <div class="form-group mb-3">
                    <label for="iScanSuratBalasan">Lampiran Surat Balasan</strong></label>
                    <input type="file" name="scan_surat_balasan" id="iScanSuratBalasan" class="form-control" accept=".pdf,.jpg,.png">
                </div>
            @endif

            <div class="d-flex align-items-center gap-2">
                <!-- Tombol Simpan -->
                <button type="submit" class="btn btn-primary">Simpan</button>

                <!-- Tombol Cetak PDF, jika file belum ada -->
                @if(isset($balasan) && is_null($balasan->scan_surat_balasan))
                    <a href="{{ route('proposal_masuk.cetakpdfpermohonanmasuk', ['id' => $rc->id]) }}" class="btn btn-success" target="_blank">Cetak PDF</a>
                @endif
            </div>
        </div>
    </div>
</div>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>
