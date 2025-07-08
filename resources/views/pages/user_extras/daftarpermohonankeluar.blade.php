<x-app-layout pageTitle="Daftar Permohonan">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <x-breadcrumb pageTitle="Daftar Permohonan" />
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">

            {{-- Notifikasi jika ada --}}
            @if (session('result') == 'success')
                <div class="alert alert-success">
                    Data berhasil disimpan! Silahkan tambahkan peserta
                </div>
            @endif

            <div class="card-header mb-3">
                <h1 class="card-title h1">DAFTAR PERMOHONAN</h1>
            </div>

            <div class="card mb-4">
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th rowspan="2" class="text-center">DATA SURAT PERMINTAAN</th> 
                                <th colspan="4" class="text-center">PESERTA</th> 
                                <th rowspan="2" class="text-center">STATUS</th> 
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
                            @forelse($permintaan as $dt)
                                @if($dt->masterMgng->masterSklh->id_user == Auth::user()->id)
                                    <tr>
                                        <td>
                                            <ul class="list-unstyled">
                                                <li><span class="mdi mdi-sort-numeric-ascending"></span> {{ $dt->nomor_surat_permintaan }}</li>
                                                <li><span class="mdi mdi-calendar-month"></span> {{ \Carbon\Carbon::parse($dt->tanggal_surat_permintaan)->locale('id')->translatedFormat('d F Y') }}</li>
                                                <li><span class="mdi mdi-information-variant"></span> {{ $dt->perihal_surat_permintaan }}</li>
                                                <li><span class="mdi mdi-email"></span> <a href="{{ asset('storage/' . $dt->scan_surat_permintaan) }}" target="_blank">Surat Permohonan</a></li>
                                                <li><span class="mdi mdi-file"></span>  <a href="{{ asset('storage/' . $dt->scan_proposal_magang) }}" target="_blank">Proposal Magang</a></li>
                                            </ul>
                                        </td>

                                        <!-- Kolom PESERTA -->
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
                                                    <a href="{{ route('user.editpesertamagang', ['id' => $de->id]) }}">
                                                        @if($dt->status_surat_permintaan == 'belum')
                                                            Edit Peserta
                                                        @else
                                                            Lihat Peserta
                                                        @endif
                                                    </a><br>
                                                @endif
                                            @endforeach
                                        </td>

                                        <!-- Kolom STATUS -->
                                        <td class="text-center">
                                            @if($dt->status_surat_permintaan == 'belum')
                                                Belum Terkirim
                                            @else
                                                Menunggu Persetujuan
                                            @endif
                                        </td>

                                        <!-- Kolom OPSI -->
                                        <td class="text-center">
                                            <a href="{{ route('user.viewpermohonankeluar', ['id' => $dt->id]) }}" class="btn btn-primary">
                                                <span class="mdi mdi-eye"></span>
                                            </a>
                                            
                                            {{-- Tombol "Tambah Peserta" hanya tampil jika status_surat_permintaan = 'belum' --}}
                                            @if($dt->status_surat_permintaan == 'belum')
                                                <a href="{{ route('user.addpesertamagang', ['id' => $dt->id]) }}" class="btn btn-success">
                                                    <span class="mdi mdi-account-plus"></span>
                                                </a>
                                            @endif

                                            <!-- Tombol hapus permohonan, akan memunculkan modal -->
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal_{{ $dt->id }}">
                                                <span class="mdi mdi-delete"></span>
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Data permohonan tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    @foreach($permintaan as $dt)
        <div class="modal fade" id="deleteModal_{{ $dt->id }}" tabindex="-1" aria-labelledby="deleteLabel_{{ $dt->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteLabel_{{ $dt->id }}">Hapus Permohonan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Yakin ingin menghapus permohonan dengan nomor <strong>{{ $dt->nomor_surat_permintaan }}</strong>?
                        <form action="{{ route('user.hapus_permohonan', ['id' => $dt->id]) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $dt->id }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                        </form>
                </div>
            </div>
        </div>
    @endforeach
</x-app-layout>
