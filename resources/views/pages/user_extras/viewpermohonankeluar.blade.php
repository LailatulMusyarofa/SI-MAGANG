<x-app-layout pageTitle="Detail Permohonan">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-arrows breadcrumb-muted">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Beranda</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('user.daftar_permohonan') }}">Daftar Permohonan</a>
                        </li>
                        <li class="breadcrumb-item muted" aria-current="page">
                            Detail Permohonan
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl mb-2">

            {{-- Notifikasi jika peserta berhasil ditambahkan --}}
            @if (session('result_psrt'))
                <div class="alert alert-success">
                    {{ session('result_psrt') }}
                </div>
            @endif

            {{-- Notifikasi jika status permohonan tidak bisa diubah --}}
            @if (session('result_mohon'))
                <div class="alert alert-success">
                    {{ session('result_mohon') }}
                </div>
            @endif

            {{-- Notifikasi jika gagal menghapus --}}
            @if (session('result'))
                <div class="alert alert-danger">
                    {{ session('result') }}
                </div>
            @endif

             @if (session('result_edit'))
                <div class="alert alert-success">
                    {{ session('result_edit') }}
                </div>
            @endif


            @if(Auth::user()->akun_diverifikasi == 'sudah')
            <form action="{{ route('user.updatestatuspermohonan', ['id' => $permohonan->id]) }}" method="POST">
                @csrf

                {{-- Tombol Edit hanya tampil jika status_surat_permintaan = 'belum' --}}
                @if($permohonan->status_surat_permintaan == 'belum')
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <a class="btn btn-success" href="{{ route('user.editpermohonankeluar', ['id' => $permohonan->id]) }}">
                                    <span class="mdi mdi-square-edit-outline"> Edit</span> 
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <span class="mdi mdi-send"> Kirim</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </form>

            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header with-border">
                            <h3 class="card-title" style="font-size: 30px;">Mohon Diperhatikan!</h3>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>Pihak lembaga pendidikan wajib menambahkan peserta terlebih dahulu sebelum bisa mengirim permohonan.</li>
                                <li>Pastikan data yang Anda kirimkan benar. Dikarenakan data yang terkirim tidak bisa diedit lagi.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <!-- Informasi Dasar -->
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-header with-border">
                            <h3 class="card-title">Informasi Dasar</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Nomor Surat Permintaan</td>
                                    <td>{{ $permohonan->nomor_surat_permintaan }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Surat Permintaan</td>
                                    <td>{{ \Carbon\Carbon::parse($permohonan->tanggal_surat_permintaan)->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Perihal Surat Permintaan</td>
                                    <td>{{ $permohonan->perihal_surat_permintaan }}</td>
                                </tr>
                                <tr>
                                    <td>Ditandatangani Oleh</td>
                                    <td>{{ $permohonan->ditandatangani_oleh }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Daftar Peserta -->
                <div class="col-md-6 mb-3">
                    <div class="card">
                        {{-- Tombol "Tambah Peserta" hanya tampil jika status_surat_permintaan = 'belum' --}}
                        @if($permohonan->status_surat_permintaan == 'belum')
                        <div class="card-header">
                            <a href="{{ route('user.addpesertamagang', ['id' => $permohonan->id]) }}" class="btn btn-success btn-sm">
                                <span class="mdi mdi-account-plus"> Tambah Peserta</span>
                            </a>
                        </div>
                        @endif

                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="4" class="text-center">DAFTAR PESERTA</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Nama Peserta</th>
                                        <th class="text-center">NIS/NIM</th>
                                        <th class="text-center">Program Studi</th>
                                        <th class="text-center">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($peserta as $dt)
                                    @if($dt->permintaan_mgng_id == $permohonan->id)
                                    <tr>
                                        <td>{{ $dt->nama_peserta }}</td>
                                        <td class="text-center">{{ $dt->nis_peserta }}</td>
                                        <td class="text-center">{{ $dt->program_studi }}</td>
                                        <td class="text-center">
                                            {{-- Tombol "Lihat Peserta" hanya tampil jika status_surat_permintaan = 'terkirim' --}}
                                            <a href="{{ route('user.editpesertamagang', ['id' => $dt->id]) }}" class="btn btn-primary btn-sm">
                                                <span class="mdi mdi-eye"></span>
                                            </a>
                                            @if($permohonan->status_surat_permintaan == 'belum')
                                            <form action="{{ route('user.hapuspesertamagang', ['id' => $dt->id]) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <span class="mdi mdi-delete"></span>
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- File Pendukung -->
            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header with-border">
                            <h3 class="card-title">File Pendukung</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr> 
                                    <td>File Scan Surat Permintaan</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $permohonan->scan_surat_permintaan) }}" target="_blank">
                                            {{ basename($permohonan->scan_surat_permintaan) }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>File Scan Proposal Magang</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $permohonan->scan_proposal_magang) }}" target="_blank">
                                            {{ basename($permohonan->scan_proposal_magang) }}
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="alert alert-danger">
                Akses Ditolak! Anda tidak diizinkan untuk mengakses halaman ini.
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
