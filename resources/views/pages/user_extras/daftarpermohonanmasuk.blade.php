<x-app-layout pageTitle="Daftar Diterima">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <x-breadcrumb pageTitle="Daftar Diterima" />
            </div>
        </div>
    </x-page-header>

     <div class="page-body">
        <div class="container-xl">
            <div class="card-header mb-3">
                <h1 class="card-title h1">DAFTAR DITERIMA</h1>
            </div>
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th rowspan="2">PERMOHONAN DAN BALASAN</th>
                                <th colspan="4" class="text-center">PESERTA</th>
                                <th rowspan="2" class="text-center">OPSI</th>
                            </tr>
                            <tr>
                                <th class="text-center">NIS/NIM</th>
                                <th class="text-center">NAMA</th>
                                <th class="text-center">PROGRAM STUDI</th>
                                <th class="text-center">OPSI PESERTA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permintaan as $dt)
                                <tr>
                                    <td>
                                        {{-- PERMOHONAN DAN BALASAN --}}
                                        <table>
                                            <b>Permohonan</b><br>
                                            <span class="mdi mdi-sort-numeric-ascending"></span> {{ $dt->nomor_surat_permintaan }}<br>
                                            <span class="mdi mdi-calendar-month"></span> {{ \Carbon\Carbon::parse($dt->tanggal_surat_permintaan)->translatedFormat('d F Y') }}<br>
                                            <span class="mdi mdi-email"></span> <a href="{{ asset('storage/' . $dt->scan_surat_permintaan) }}" target="_blank"> Surat Permohonan</a><br>
                                            <span class="mdi mdi-file"></span> <a href="{{ asset('storage/' . $dt->scan_proposal_magang) }}" target="_blank"> Proposal Magang</a><br><br>
                                            <b>Balasan</b><br>
                                            <span class="mdi mdi-sort-numeric-ascending"></span> {{ '400.14.5.4/' . optional($dt->balasan)->nomor_surat_balasan ?? 'Tidak Tersedia' }}/114.1/{{ \Carbon\Carbon::parse(optional($dt->balasan)->tanggal_surat_balasan)->format('Y') ?? 'Tidak Tersedia' }}<br>
                                            <span class="mdi mdi-calendar-month"></span> {{ \Carbon\Carbon::parse(optional($dt->balasan)->tanggal_surat_balasan ?? now())->translatedFormat('d F Y') ?? 'Tidak Tersedia' }}<br>
                                            <span class="mdi mdi-email"></span> <a href="{{ asset('storage/scan_surat_balasan/'.optional($dt->balasan)->scan_surat_balasan) }}" target="_blank"> Surat Balasan</a><br><br>
                                            <b>Waktu Pelaksanaan</b><br>
                                            <span class="mdi mdi-calendar-check"></span> {{ \Carbon\Carbon::parse(optional($dt->balasan)->tanggal_awal_magang ?? now())->translatedFormat('d F Y') }} s.d. {{ \Carbon\Carbon::parse(optional($dt->balasan)->tanggal_akhir_magang ?? now())->translatedFormat('d F Y') }}<br>
                                        </table>
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
                                        @foreach($data2 as $de)
                                            @if($de->permintaan_mgng_id == $dt->id)
                                                <a href="{{ route('user_extras.viewpesertamasuk', ['id' => $de->id]) }}">Lihat Data Peserta</a><br>
                                            @endif
                                        @endforeach
                                    </td>

                                    <!-- Kolom OPSI dengan ikon mata -->
                                    <td class="text-center">
                                        <a href="{{ route('user.detail_permohonanmasuk', ['id' => $dt->id]) }}" class="btn btn-info">
                                            <span class="mdi mdi-eye"></span> 
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            @if($permintaan->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Data permohonan magang tidak ditemukan.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>