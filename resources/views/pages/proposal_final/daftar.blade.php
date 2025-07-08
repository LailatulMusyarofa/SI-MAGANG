<x-app-layout pageTitle="Permohonan Magang">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <x-breadcrumb pageTitle="Laporan & Sertifikat" />
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">
             <div class="card-header mb-3">
                <h1 class="card-title h1">DAFTAR LAPORAN & SERTIFIKAT</h1>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <form method="GET" action="{{ route('nota_dinas.daftar') }}" class="d-flex ms-auto" style="max-width: 300px;">
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
                                <th rowspan="2">LEMBAGA PENDIDIKAN</th>
                                <th rowspan="2">PERMOHONAN DAN BALASAN</th>
                                <th rowspan="2">NOTA DINAS</th>
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
                            @foreach($data as $dt)
                                @if($dt->status_surat_permintaan == 'terkirim' && optional($dt->balasan)->scan_surat_balasan != null)
                                    <tr>
                                        <td>
                                            <b>Lembaga Pendidikan</b><br>
                                            <span class="mdi mdi-bank"></span> {{ $dt->masterMgng->masterSklh->user->fullname ?? 'Tidak Diketahui' }}<br>
                                            <span class="mdi mdi-map-marker"></span> {{ $dt->masterMgng->masterSklh->kabko_sklh ?? 'Provinsi Lainnya' }}
                                            <br><br>
                                            <b>Narahubung</b><br>
                                            <span class="mdi mdi-account"></span> {{ $dt->masterMgng->masterSklh->nama_narahubung ?? 'Tidak Diketahui' }}<br>
                                            <span class="mdi mdi-gender-male-female"></span> {{ ucfirst($dt->masterMgng->masterSklh->jenis_kelamin_narahubung ?? 'Tidak Diketahui') }}<br>
                                            <span class="mdi mdi-briefcase-variant"></span> {{ $dt->masterMgng->masterSklh->jabatan_narahubung ?? 'Tidak Diketahui' }}<br>
                                            <span class="mdi mdi-phone"></span> {{ $dt->masterMgng->masterSklh->handphone_narahubung ?? 'Tidak Diketahui' }}
                                        </td>
                                        <td>
                                            <table>
                                                <b>Permohonan</b><br>
                                                <span class="mdi mdi-sort-numeric-ascending"></span> {{ $dt->nomor_surat_permintaan }}<br>
                                                <span class="mdi mdi-calendar-month"></span> {{ \Carbon\Carbon::parse($dt->tanggal_surat_permintaan)->translatedFormat('d F Y') }}<br>
                                                <span class="mdi mdi-email" style="margin-right: 5px;"></span> <a href="{{ asset('storage/scan_surat_permintaan/'.$dt->scan_surat_permintaan) }}" target="_blank">Surat Permohonan</a><br>
                                                <span class="mdi mdi-file" style="margin-right: 5px;"></span>  <a href="{{ asset('storage/scan_proposal_magang/'.$dt->scan_proposal_magang) }}" target="_blank">Proposal Magang</a><br><br>
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
                                            </table>
                                        </td>
                                        <td>
                                            @if($dt->notaDinas)
                                                <span class="mdi mdi-sort-numeric-ascending"></span> 400.14.5.4/{{ $dt->notaDinas->nomor_nota_dinas }}/114.1/{{ \Carbon\Carbon::parse($dt->notaDinas->tanggal_nota_dinas)->format('Y') }}<br>
                                                <span class="mdi mdi-calendar-month"></span> {{ \Carbon\Carbon::parse($dt->notaDinas->tanggal_nota_dinas)->translatedFormat('d F Y') }}<br>
                                                <span class="mdi mdi-briefcase-variant"></span> {{ $dt->notaDinas->masterBdng->nama_bidang ?? '-' }}<br>
                                                @if($dt->notaDinas->scan_nota_dinas)
                                                    <span class="mdi mdi-file"></span>
                                                    <a href="{{ asset('storage/'.$dt->notaDinas->scan_nota_dinas) }}" target="_blank">
                                                        Scan Nota Dinas
                                                    </a>
                                                    @else
                                                        <span class="text-muted">
                                                            <span class="mdi mdi-file"></span> Scan Nota Dinas
                                                        </span>
                                                    @endif
                                                    @else
                                                        <span class="text-muted">Nota Dinas belum dibuat</span>
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
                                            @if($dt->notaDinas && $dt->notaDinas->scan_laporan_magang && $dt->notaDinas->status_laporan == 'terkirim')
                                                <a href="{{ asset('storage/' . $dt->notaDinas->scan_laporan_magang) }}" target="_blank">Laporan</a>
                                            @else
                                                <span class="text-muted">Belum diupload</span>
                                            @endif
                                        </td>
                                        <td style="text-align: center">
                                           <a href="{{ route('proposal_final.tanggapi', ['id' => $dt->id]) }}" class="btn btn-success"><span class="mdi mdi-pencil"></span></a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @if($data->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Data permohonan magang tidak ditemukan.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center my-3">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
