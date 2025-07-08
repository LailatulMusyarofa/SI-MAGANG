<x-app-layout pageTitle="Laporan Nota Dinas">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <x-breadcrumb pageTitle="Daftar Laporan" />
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">
            <div class="card-header mb-3">
                <h1 class="card-title h1">DAFTAR LAPORAN</h1>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <form method="GET" action="{{ route('user.daftar_laporanmagang') }}" class="d-flex">
                        <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control me-2" placeholder="Pencarian">
                        <button type="submit" class="btn btn-secondary">
                            <span class="mdi mdi-magnify"></span>
                        </button>
                    </form>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th rowspan="2">PERMOHONAN DAN BALASAN</th>
                                <th rowspan="2">PENEMPATAN</th>
                                <th colspan="6" class="text-center">PESERTA</th>
                                <th rowspan="2">OPSI</th>
                            </tr>
                            <tr>
                                <th class="text-center">NIS/NIM</th>
                                <th class="text-center">NAMA</th>
                                <th class="text-center">PROGRAM STUDI</th>
                                <th class="text-center">NILAI</th>
                                <th class="text-center">PENILAI</th>
                                <th class="text-center">OPSI PESERTA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $dt)
                                @if(optional($dt->notaDinas)->status_nota_dinas == 'terkirim')
                                    <tr>
                                        <td>
                                            <b>Permohonan</b><br>
                                            <span class="mdi mdi-sort-numeric-ascending"></span> {{ $dt->nomor_surat_permintaan }}<br>
                                            <span class="mdi mdi-calendar-month"></span> 
                                            {{ \Carbon\Carbon::parse($dt->tanggal_surat_permintaan)->translatedFormat('d F Y') }}<br>
                                            <span class="mdi mdi-email" style="margin-right: 5px;"></span> 
                                            <a href="{{ asset('storage/scan_surat_permintaan/'.$dt->scan_surat_permintaan) }}" target="_blank">Surat Permohonan</a><br>
                                            <span class="mdi mdi-file" style="margin-right: 5px;"></span>  
                                            <a href="{{ asset('storage/scan_proposal_magang/'.$dt->scan_proposal_magang) }}" target="_blank">Proposal Magang</a><br><br>
                                            <b>Balasan</b><br>
                                            <span class="mdi mdi-sort-numeric-ascending"></span> 
                                            {{ '400.14.5.4/' . optional($dt->balasan)->nomor_surat_balasan ?? 'Tidak Tersedia' }}/114.1/{{ \Carbon\Carbon::parse(optional($dt->balasan)->tanggal_surat_balasan)->format('Y') ?? 'Tidak Tersedia' }}<br>
                                            <span class="mdi mdi-calendar-month"></span> 
                                            {{ \Carbon\Carbon::parse(optional($dt->balasan)->tanggal_surat_balasan ?? now())->translatedFormat('d F Y') ?? 'Tidak Tersedia' }}<br>
                                            <span class="mdi mdi-email" style="margin-right: 5px;"></span>
                                            <a href="{{ asset('storage/scan_surat_balasan/'.optional($dt->balasan)->scan_surat_balasan) }}" target="_blank">Surat Balasan</a><br><br>
                                            <b>Waktu Pelaksanaan</b><br>
                                            <span class="mdi mdi-calendar-check"></span> 
                                            {{ \Carbon\Carbon::parse(optional($dt->balasan)->tanggal_awal_magang ?? now())->translatedFormat('d F Y') }} s.d. 
                                            {{ \Carbon\Carbon::parse(optional($dt->balasan)->tanggal_akhir_magang ?? now())->translatedFormat('d F Y') }}<br>
                                        </td>
                                        <td>
                                            @if($dt->notaDinas)
                                                {{ $dt->notaDinas->masterBdng->nama_bidang ?? '-' }}<br>
                                            @else
                                                <span class="text-muted">Belum ditempatkan</span>
                                            @endif
                                        </td>

                                        {{-- Peserta dan kolom tambahan --}}
                                         @php
                                            $pesertas = $data2->where('permintaan_mgng_id', $dt->id);
                                        @endphp

                                        <td class="text-center">
                                            @foreach($pesertas as $de)
                                                {{ $de->nis_peserta }}<br>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            @foreach($pesertas as $de)
                                                {{ $de->nama_peserta }}<br>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            @foreach($pesertas as $de)
                                                {{ $de->program_studi }}<br>
                                            @endforeach
                                        </td>

                                        <td class="text-center">
                                            @foreach($pesertas as $de)
                                                {{ $de->nilai_akhir ?? 'N/A' }}<br>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            @foreach($pesertas as $de)
                                                {{ $de->bdngMember->nama_pejabat ?? 'N/A' }}<br>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            @foreach($pesertas as $de)
                                                <div class="d-inline-block me-3 mb-1 align-middle">
                                                    {{-- Trophy --}}
                                                    @if($de->status_penilaian == 'sudah' && $de->scan_penilaian)
                                                        <a href="{{ asset('storage/' . $de->scan_penilaian) }}" target="_blank" class="btn btn-success btn-sm" title="Lihat Nilai">
                                                            <span class="mdi mdi-trophy"></span>
                                                        </a>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif

                                                    {{-- Sertifikat --}}
                                                    @if($de->status_sertifikat == 'terkirim' && $de->scan_sertifikat)
                                                        <a href="{{ asset('storage/' . $de->scan_sertifikat) }}" target="_blank" class="btn btn-info btn-sm ms-1" title="Lihat Sertifikat">
                                                            <span class="mdi mdi-certificate"></span>
                                                        </a>
                                                    @else
                                                        <span class="text-muted ms-1">N/A</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </td>
                                        <td style="text-align: center; white-space: nowrap;">
                                            <a href="{{ route('user.previewlaporan', ['id' => $dt->id]) }}" class="btn btn-info" title="View">
                                                <span class="mdi mdi-eye"></span>
                                            </a>
                                            <a href="{{ route('user.showuploadlaporan', ['id' => $dt->id]) }}" class="btn btn-primary" title="Upload Laporan">
                                                <span class="mdi mdi-pencil"></span>
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted">Data laporan magang tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
