<x-app-layout pageTitle="Permohonan Magang">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <x-breadcrumb pageTitle="Daftar Permohonan Magang" />
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">
            <div class="card-header mb-3">
                <h1 class="card-title h1">DAFTAR PERMOHONAN MAGANG</h1>
            </div>
            <div class="card">
                <div class="card-header">
                    <form method="GET" action="{{ route('proposal_masuk') }}" class="d-flex ms-auto" style="max-width: 300px;">
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
                                <th rowspan="2">DATA SURAT PERMOHONAN</th>
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
                        @foreach($data as $dt)
                            {{-- Menampilkan hanya yang status_surat_permintaan = "terkirim" dan belum ada balasan --}}
                            @if($dt->status_surat_permintaan == 'terkirim' && !$dt->balasan)
                                <tr>
                                    <td>
                                        {{-- Data Lembaga Pendidikan --}}
                                        <b>Lembaga Pendidikan</b><br>
                                        <span class="mdi mdi-bank"></span> {{ $dt->masterMgng->masterSklh->user->fullname ?? 'Tidak Diketahui' }}<br>
                                        <span class="mdi mdi-map-marker"></span> {{ $dt->masterMgng->masterSklh->kabko_sklh ?? 'Provinsi Lainnya' }}
                                        <br><br>
                                        {{-- Data Narahubung --}}
                                        <b>Narahubung</b><br>
                                        <span class="mdi mdi-account"></span> {{ $dt->masterMgng->masterSklh->nama_narahubung ?? 'Tidak Diketahui' }}<br>
                                        <span class="mdi mdi-gender-male-female"></span> {{ ucfirst($dt->masterMgng->masterSklh->jenis_kelamin_narahubung ?? 'Tidak Diketahui') }}<br>
                                        <span class="mdi mdi-briefcase-variant"></span> {{ $dt->masterMgng->masterSklh->jabatan_narahubung ?? 'Tidak Diketahui' }}<br>
                                        <span class="mdi mdi-phone"></span> {{ $dt->masterMgng->masterSklh->handphone_narahubung ?? 'Tidak Diketahui' }}
                                    </td>
                                    <td>
                                        {{-- Data Surat Permohonan --}}
                                        <table>
                                            <span class="mdi mdi-sort-numeric-ascending"></span> {{ $dt->nomor_surat_permintaan }}<br>
                                            <span class="mdi mdi-calendar-month"></span> {{ \Carbon\Carbon::parse($dt->tanggal_surat_permintaan)->locale('id')->translatedFormat('d F Y') }}<br>
                                            <span class="mdi mdi-email"></span>&nbsp;<a href="{{ asset('storage/' . $dt->scan_surat_permintaan) }}" target="_blank">Surat Permohonan</a><br>
                                            <span class="mdi mdi-file"></span>&nbsp;<a href="{{ asset('storage/' . $dt->scan_proposal_magang) }}" target="_blank">Proposal Magang</a><br>
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
                                                <a href="{{ route('proposal_masuk.viewpeserta', ['id' => $de->id]) }}">Lihat data peserta</a><br>
                                            @endif
                                        @endforeach
                                    </td>

                                    <td style="text-align: center">
                                        <a href="{{ route('proposal_masuk.balaspermohonan', ['id' => $dt->id]) }}" class="btn btn-success"><span class="mdi mdi-reply"></span></a>
                                        <button type="button" class="btn btn-danger btn-trash" data-bs-toggle="modal" data-bs-target="#delete_{{ $dt->id }}">
                                            <span class="mdi mdi-delete"></span>
                                        </button>
                                    </td>
                                </tr>
                                <!-- MODAL DELETE -->
<form action="{{ route('proposal_masuk.hapus', ['id' => $dt->id]) }}" method="POST">
    @csrf
    @method('DELETE')
    <div class="modal fade" id="delete_{{ $dt->id }}" tabindex="-1" aria-labelledby="deleteLabel_{{ $dt->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteLabel_{{ $dt->id }}">Hapus Permohonan Magang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Yakin ingin menghapus permohonan magang dari <strong>{{ $dt->masterMgng->masterSklh->user->fullname ?? 'Lembaga Tidak Diketahui' }}</strong>?
                    <input type="hidden" name="id" value="{{ $dt->id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </div>
        </div>
    </div>
</form>
                            @endif
                        @endforeach
                        @if($data->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center text-muted">Data permohonan magang tidak ditemukan.</td>
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
