<x-app-layout pageTitle="Pilih Permohonan">
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
                    </ol>
                </nav>
            </div>
        </div>
    </x-page-header>

    @if(Auth::user()->role_id == 1)
    <div class="container-xl mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <form method="GET" action="{{ route('nota_dinas.proposalselector') }}" class="d-flex">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control me-2" placeholder="Pencarian">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-search"></i> Cari
                    </button>
                </form>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th rowspan="2">LEMBAGA PENDIDIKAN</th>
                            <th rowspan="2">PERMOHONAN DAN BALASAN</th>
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
                            <tr>
                                <td>
                                    <b>Lembaga Pendidikan</b><br>
                                    <span class="mdi mdi-bank"></span> {{ $dt->masterMgng->masterSklh->user->fullname ?? 'Tidak Diketahui' }}<br>
                                    <span class="mdi mdi-map-marker"></span> {{ $dt->masterMgng->masterSklh->kabko_sklh ?? 'Provinsi Lainnya' }}<br><br>

                                    <b>Narahubung</b><br>
                                    <span class="mdi mdi-account"></span> {{ $dt->masterMgng->masterSklh->nama_narahubung ?? 'Tidak Diketahui' }}<br>
                                    <span class="mdi mdi-gender-male-female"></span> {{ ucfirst($dt->masterMgng->masterSklh->jenis_kelamin_narahubung ?? 'Tidak Diketahui') }}<br>
                                    <span class="mdi mdi-briefcase-variant"></span> {{ $dt->masterMgng->masterSklh->jabatan_narahubung ?? 'Tidak Diketahui' }}<br>
                                    <span class="mdi mdi-phone"></span> {{ $dt->masterMgng->masterSklh->handphone_narahubung ?? 'Tidak Diketahui' }}
                                </td>
                                <td>
                                    <b>Permohonan</b><br>
                                    <span class="mdi mdi-sort-numeric-ascending"></span> {{ $dt->nomor_surat_permintaan }}<br>
                                    <span class="mdi mdi-calendar-month"></span> {{ \Carbon\Carbon::parse($dt->tanggal_surat_permintaan)->translatedFormat('d F Y') }}<br>
                                    <span class="mdi mdi-email"></span> 
                                    <a href="{{ asset('storage/scan_surat_permintaan/'.$dt->scan_surat_permintaan) }}" target="_blank">Surat Permohonan</a><br>
                                    <span class="mdi mdi-file"></span> 
                                    <a href="{{ asset('storage/scan_proposal_magang/'.$dt->scan_proposal_magang) }}" target="_blank">Proposal Magang</a><br><br>

                                    <b>Balasan</b><br>
                                    <span class="mdi mdi-sort-numeric-ascending"></span> 
                                    {{ '400.14.5.4/' . optional($dt->balasan)->nomor_surat_balasan ?? 'Tidak Tersedia' }}/114.1/{{ \Carbon\Carbon::parse(optional($dt->balasan)->tanggal_surat_balasan)->format('Y') ?? 'Tidak Tersedia' }}<br>

                                    <span class="mdi mdi-calendar-month"></span> 
                                    {{ \Carbon\Carbon::parse(optional($dt->balasan)->tanggal_surat_balasan ?? now())->translatedFormat('d F Y') ?? 'Tidak Tersedia' }}<br>

                                    <span class="mdi mdi-email"></span> 
                                    <a href="{{ asset('storage/scan_surat_balasan/'.optional($dt->balasan)->scan_surat_balasan) }}" target="_blank">Surat Balasan</a><br><br>

                                    <b>Waktu Pelaksanaan</b><br>
                                    <span class="mdi mdi-calendar-check"></span> 
                                    {{ \Carbon\Carbon::parse(optional($dt->balasan)->tanggal_awal_magang ?? now())->translatedFormat('d F Y') }} s.d. 
                                    {{ \Carbon\Carbon::parse(optional($dt->balasan)->tanggal_akhir_magang ?? now())->translatedFormat('d F Y') }}<br>
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
                                <td class="text-center">
                                    <a href="{{ route('nota_dinas.add', ['id' => $dt->id]) }}" class="btn btn-primary btn-sm">
                                        <span class="mdi mdi-arrow-right-thick"></span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        @if($data->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center text-muted">Proposal magang tidak ditemukan.</td>
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
    @endif
</x-app-layout>
