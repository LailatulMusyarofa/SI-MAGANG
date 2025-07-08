<x-app-layout pageTitle="Penilaian Peserta">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-arrows breadcrumb-muted">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Beranda</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('proposal_final.daftar') }}">Laporan & Sertifikat</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('proposal_final.tanggapi', ['id' => $permohonan->id]) }}">Detail Laporan & Sertifikat</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('proposal_final.penilaian', ['id' => $rc->id]) }}">Penilaian</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">
            @if(Auth::user()->role_id == 1)
                @if(\App\Models\NotaDinas::where('permintaan_mgng_id', $rc->id_mgng)->where('status_laporan', 'belum')->count() == 0)
                    <form method="post" enctype="multipart/form-data" action="{{ route('proposal_final.penilaian.simpan', ['id' => $rc->id]) }}">
                        @csrf

                        @if($rc->status_scan_penilaian == 'belum')
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <button type="submit" class="btn btn-primary">
                                        <span class="mdi mdi-content-save"> Simpan</span>
                                </button>
                            </div>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h3 class="card-title">Data Peserta</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr><td>Nama Peserta</td><td>:</td><td>{{ $rc->nama_peserta }}</td></tr>
                                            <tr><td>Program Studi</td><td>:</td><td>{{ $rc->program_studi }}</td></tr>
                                            <tr><td>Nomor Handphone</td><td>:</td><td>{{ $rc->no_handphone_peserta }}</td></tr>
                                            <tr><td>E-mail</td><td>:</td><td>{{ $rc->email_peserta }}</td></tr>
                                            <tr>
                                                <td>Ditempatkan di</td>
                                                <td>:</td>
                                                <td>
                                                    {{ optional($rc->notaDinas->masterBdng)->nama_bidang ?? 'Belum ditempatkan' }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                @if($rc->status_scan_penilaian == 'belum')
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h3 class="card-title">Catatan</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="catatan" class="form-label">Catatan terkait peserta selama pelaksanaan magang</label>
                                            <textarea id="catatan" name="catatan" rows="4" class="form-control @error('catatan') is-invalid @enderror" placeholder="Masukkan catatan">{{ old('catatan', $rc->catatan) }}</textarea>
                                            @error('catatan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h3 class="card-title">Informasi Dasar Penilaian</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="iIdBdngMember" class="form-label">Yang menilai</label>
                                            <select id="iIdBdngMember" name="id_bdng_member" class="form-select @error('id_bdng_member') is-invalid @enderror">
                                                @php $val = old('id_bdng_member', $rc->id_bdng_member); @endphp
                                                @foreach($bdngMembers as $bdngm)
                                                    <option value="{{ $bdngm->id }}" {{ $val == $bdngm->id ? 'selected' : '' }}>
                                                        {{ $bdngm->nama_pejabat }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_bdng_member') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h3 class="card-title">Penanda Tangan</h3>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Nama:</strong> {{ $rc->nama_pejabat ?? '-' }}</p>
                                        <p><strong>Jabatan:</strong> {{ $rc->jabatan_pejabat ?? '-' }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="col-lg-6">
                                @if($rc->status_scan_penilaian == 'belum')
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h3 class="card-title">Form Penilaian Kedisiplinan</h3>
                                    </div>
                                    <div class="card-body">
                                        @foreach([
                                            'kehadiran' => 'Nilai Kehadiran',
                                            'kerapian' => 'Nilai Kerapian',
                                            'sikap' => 'Nilai Sikap',
                                            'tanggungjawab' => 'Nilai Tanggung Jawab',
                                            'kepatuhan' => 'Nilai Kepatuhan',
                                        ] as $field => $label)
                                            <div class="mb-3">
                                                <label for="iNilai{{ ucfirst($field) }}" class="form-label">{{ $label }}</label>
                                                <input type="number" id="iNilai{{ ucfirst($field) }}" name="nilai_{{ $field }}" class="form-control @error('nilai_'.$field) is-invalid @enderror" value="{{ old('nilai_'.$field, $rc->{'nilai_'.$field}) }}" placeholder="Masukkan {{ strtolower($label) }}" step="0.1" min="0" max="100">
                                                @error('nilai_'.$field)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h3 class="card-title">Form Penilaian Kreativitas</h3>
                                    </div>
                                    <div class="card-body">
                                        @foreach([
                                            'komunikasi' => 'Nilai Komunikasi',
                                            'kerjasama' => 'Nilai Kerjasama',
                                            'inisiatif' => 'Nilai Inisiatif',
                                        ] as $field => $label)
                                            <div class="mb-3">
                                                <label for="iNilai{{ ucfirst($field) }}" class="form-label">{{ $label }}</label>
                                                <input type="number" id="iNilai{{ ucfirst($field) }}" name="nilai_{{ $field }}" class="form-control @error('nilai_'.$field) is-invalid @enderror" value="{{ old('nilai_'.$field, $rc->{'nilai_'.$field}) }}" placeholder="Masukkan {{ strtolower($label) }}" step="0.1" min="0" max="100">
                                                @error('nilai_'.$field)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h3 class="card-title">Form Penilaian Teknis</h3>
                                    </div>
                                    <div class="card-body">
                                        @foreach([
                                            'teknis1' => 'Nilai Teknis 1',
                                            'teknis2' => 'Nilai Teknis 2',
                                            'teknis3' => 'Nilai Teknis 3',
                                            'teknis4' => 'Nilai Teknis 4',
                                        ] as $field => $label)
                                            <div class="mb-3">
                                                <label for="iNilai{{ ucfirst($field) }}" class="form-label">{{ $label }}</label>
                                                <input type="number" id="iNilai{{ ucfirst($field) }}" name="nilai_{{ $field }}" class="form-control @error('nilai_'.$field) is-invalid @enderror" value="{{ old('nilai_'.$field, $rc->{'nilai_'.$field}) }}" placeholder="Masukkan {{ strtolower($label) }}" step="0.1" min="0" max="100">
                                                @error('nilai_'.$field)
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @else
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Nilai Akhir</h3>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-bordered mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Keterangan</th>
                                                    <th>Skor</th>
                                                    <th>Bobot</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr><td>Kedisiplinan</td><td>{{ $rc->nilai_kedisiplinan }}</td><td>10%</td><td>{{ $rc->nilai_kedisiplinan * 0.1 }}</td></tr>
                                                <tr><td>Tanggungjawab</td><td>{{ $rc->nilai_tanggungjawab }}</td><td>10%</td><td>{{ $rc->nilai_tanggungjawab * 0.1 }}</td></tr>
                                                <tr><td>Kerjasama</td><td>{{ $rc->nilai_kerjasama }}</td><td>10%</td><td>{{ $rc->nilai_kerjasama * 0.1 }}</td></tr>
                                                <tr><td>Motivasi</td><td>{{ $rc->nilai_motivasi }}</td><td>10%</td><td>{{ $rc->nilai_motivasi * 0.1 }}</td></tr>
                                                <tr><td>Pengetahuan</td><td>{{ $rc->nilai_pengetahuan }}</td><td>15%</td><td>{{ $rc->nilai_pengetahuan * 0.15 }}</td></tr>
                                                <tr><td>Pelaksanaan Kerja</td><td>{{ $rc->nilai_pelaksanaankerja }}</td><td>15%</td><td>{{ $rc->nilai_pelaksanaankerja * 0.15 }}</td></tr>
                                                <tr><td>Hasil Kerja</td><td>{{ $rc->nilai_hasilkerja }}</td><td>15%</td><td>{{ $rc->nilai_hasilkerja * 0.15 }}</td></tr>
                                                <tr>
                                                    <td colspan="3" class="text-center"><strong>Total</strong></td>
                                                    <td>{{ $rc->nilai_akhir }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </form>
                @else
                    <div class="alert alert-danger">
                        <strong>Tidak dapat membuka form penilaian!</strong><br>
                        Belum ada laporan yang dikirim dari lembaga pendidikan!<br>
                        Tekan <a href="javascript:history.back()"><i class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                @endif
            @else
                <div class="alert alert-danger">
                    <strong>Akses ditolak!</strong><br>
                    Anda tidak memiliki akses ke halaman ini!<br>
                    Tekan <a href="javascript:history.back()"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
