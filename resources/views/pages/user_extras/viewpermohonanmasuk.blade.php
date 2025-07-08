<x-app-layout pageTitle="Detail Permohonan">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <!-- Breadcrumb or other content here -->
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">
            @if(Auth::user()->akun_diverifikasi == 'sudah')
                @if(session('result') == 'update')
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-check"></i> Alert!</h4>
                        Data berhasil diperbaharui
                    </div>
                @endif

                @if(session('result') == 'fail-delete')
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-check"></i> Alert!</h4>
                        Data gagal dihapus
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">File</h5>
                            </div>
                            <div class="card-body">
                                <table style="font-size: 12pt; border-collapse: separate; border-spacing: 0 15px">
                                    <tr>
                                        <td>File Surat Permohonan</td><td width="20px" align="center">:</td>
                                        <td>
                                            @if($rc->scan_surat_permintaan)
                                                <a target="_blank" href="{{ asset('storage/' . $rc->scan_surat_permintaan) }}">{{ basename($rc->scan_surat_permintaan) }}</a>
                                            @else
                                                <span>No file uploaded</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>File Proposal Magang</td><td width="20px" align="center">:</td>
                                        <td>
                                            @if($rc->scan_proposal_magang)
                                                <a target="_blank" href="{{ asset('storage/' . $rc->scan_proposal_magang) }}">{{ basename($rc->scan_proposal_magang) }}</a>
                                            @else
                                                <span>No file uploaded</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>File Surat Balasan</td><td width="20px" align="center">:</td>
                                        <td>
                                            @if($rc->balasan)
                                                <a target="_blank" href="{{ asset('storage/scan_surat_balasan/'.$rc->balasan->scan_surat_balasan) }}">{{ $rc->balasan->scan_surat_balasan }}</a>
                                            @else
                                                Tidak ada balasan
                                            @endif
                                        </td>
                                    </tr>
                                    @if($rc->status_sertifikat == 'terkirim')
                                        <tr>
                                            <td>Link Sertifikat</td><td width="20px" align="center">:</td>
                                            <td><a target="_blank" href="{{ $rc->scan_sertifikat }}">{{ $rc->scan_sertifikat }}</a></td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Daftar Peserta</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nama Peserta</th>
                                            <th>NIS/NIM Peserta</th>
                                            <th>Program Studi</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($rd as $dt)
                                            @if($dt->permintaan_mgng_id == $rc->id)
                                                <tr>
                                                    <td>{{ $dt->nama_peserta }}</td>
                                                    <td>{{ $dt->nis_peserta }}</td>
                                                    <td>{{ $dt->program_studi }}</td>
                                                    <td>
                                                        <a href="{{ route('user_extras.viewpesertamasuk', ['id' => $dt->id]) }}" class="btn btn-primary">
                                                            <span class="mdi mdi-eye"></span> 
                                                        </a>

                                                        {{-- Tombol piala --}}
                                                        @if($dt->status_penilaian == 'sudah' && $dt->scan_penilaian)
                                                            <a href="{{ asset('storage/' . $dt->scan_penilaian) }}" class="btn btn-sm btn-success" target="_blank">
                                                                <span class="mdi mdi-trophy"></span>
                                                            </a>
                                                        @endif

                                                        {{-- Tombol sertifikat --}}
                                                        @if($dt->status_sertifikat == 'terkirim' && $dt->scan_sertifikat)
                                                            <a href="{{ asset('storage/' . $dt->scan_sertifikat) }}" class="btn btn-sm btn-info" target="_blank">
                                                                <span class="mdi mdi-certificate"></span>
                                                            </a>
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
            @else
                <div class="alert alert-danger">
                    Anda tidak diizinkan untuk mengakses halaman ini!
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
