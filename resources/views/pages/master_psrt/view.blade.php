<x-app-layout pageTitle="Detail Peserta">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-arrows breadcrumb-muted">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Beranda</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('proposal_masuk') }}">Daftar Permohonan</a>
                        </li>
                        <li class="breadcrumb-item muted" aria-current="page">
                            Detail Peserta
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">
            @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                <!-- Privilege Check -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Detail Peserta</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Nama Peserta</td><td>{{ $data->nama_peserta }}</td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Kelamin</td><td>{{ ucfirst($data->jenis_kelamin) }}</td>
                                    </tr>
                                    <tr>
                                        <td>NIK Peserta</td><td>{{ $data->nik_peserta }}</td>
                                    </tr>
                                    <tr>
                                        <td>NIS/NIM Peserta</td><td>{{ $data->nis_peserta }}</td>
                                    </tr>
                                    <tr>
                                        <td>Program Studi</td><td>{{ $data->program_studi }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Handphone</td><td>{{ $data->no_handphone_peserta }}</td>
                                    </tr>
                                    <tr>
                                        <td>E-mail</td><td>{{ $data->email_peserta }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-6">
                        <div class="card bg-danger text-white">
                            <div class="card-header">
                                <h3 class="card-title">Akses Ditolak!</h3>
                            </div>
                            <div class="card-body">
                                Anda tidak memiliki akses ke halaman ini!<br>
                                Tekan <a href="javascript:history.back()" class="text-white"><i class="fa fa-fw fa-arrow-left"></i> untuk kembali ke halaman sebelumnya</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
