<x-app-layout pageTitle="Permohonan Magang">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <x-breadcrumb pageTitle="Nota Dinas Magang" />
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">
            <div class="card-header mb-3">
                <h1 class="card-title h1">DAFTAR NOTA DINAS</h1>
            </div>
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a class="btn btn-success text-white" href="{{ route('nota_dinas.proposalselector') }}">
                        <span class="mdi mdi-plus-thick"></span>
                    </a>
                    <form method="GET" action="{{ route('nota_dinas.daftar') }}" class="d-flex">
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
                                <th colspan="3" class="text-center">PESERTA</th>
                                <th rowspan="2" class="text-center">OPSI</th>
                            </tr>
                            <tr>
                                <th class="text-center">NIS/NIM</th>
                                <th class="text-center">NAMA</th>
                                <th class="text-center">PROGRAM STUDI</th>
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
                                        <td class="text-center">
                                            @foreach($data2 as $de)
                                                @if($de->permintaan_mgng_id == $dt->id)
                                                    {{ $de->nis_peserta }}<br>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            @foreach($data2 as $de)
                                                @if($de->permintaan_mgng_id == $dt->id)
                                                    {{ $de->nama_peserta }}<br>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            @foreach($data2 as $de)
                                                @if($de->permintaan_mgng_id == $dt->id)
                                                    {{ $de->program_studi }}<br>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td style="text-align: center">
                                            <a href="{{ route('nota_dinas.edit', ['id' => $dt->notaDinas->id]) }}" class="btn btn-success"><span class="mdi mdi-pencil"></span></a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            @if($data->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Nota Dinas magang tidak ditemukan.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="card-footer d-flex justify-content-center">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
