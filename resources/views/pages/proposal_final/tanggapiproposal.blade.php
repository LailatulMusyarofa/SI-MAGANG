<x-app-layout pageTitle="Detail Laporan & Sertifikat">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-arrows breadcrumb-muted">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Beranda</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('proposal_final.daftar') }}">Laporan & Sertifikat</a>
                        </li>
                         <li class="breadcrumb-item">
                            <a href="{{ route('proposal_final.tanggapi', ['id' => $permohonan->id]) }}">Detail Laporan & Sertifikat</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">
            @if(Auth::user()->role_id == 1)
                @if($peserta->count() > 0)
                    @if(\App\Models\NotaDinas::where('permintaan_mgng_id', $permohonan->id)->where('status_laporan', 'belum')->count() == 0)
                        <form role="form" method="post" enctype="multipart/form-data" action="{{ route('proposal_masuk.tanggapiproposal', ['id' => $permohonan->id]) }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title" style="font-size: 30px">Daftar Peserta</h3>
                                        </div>
                                        <div class="card-body table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Nama Peserta</th>
                                                        <th class="text-center">NIS/NIM Peserta</th>
                                                        <th class="text-center">Program Studi</th>
                                                        <th class="text-center">Bidang</th>
                                                        <th class="text-center">Nilai</th>
                                                        <th class="text-center">Opsi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($peserta as $dt)
                                                        <tr>
                                                            <td>{{ $dt->nama_peserta }}</td>
                                                            <td>{{ $dt->nis_peserta }}</td>
                                                            <td>{{ $dt->program_studi }}</td>
                                                            <td>
                                                                @if($permohonan->notaDinas && $permohonan->notaDinas->masterBdng)
                                                                    {{ $permohonan->notaDinas->masterBdng->nama_bidang }}
                                                                @else
                                                                    <span class="text-muted">Belum ditempatkan</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($dt->status_penilaian == 'sudah')
                                                                    {{ $dt->nilai_akhir }}
                                                                @else
                                                                    Belum dinilai
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($permohonan->notaDinas && $permohonan->notaDinas->scan_laporan_magang)
                                                                    <a href="{{ asset('storage/' . $permohonan->notaDinas->scan_laporan_magang) }}" class="btn btn-success" target="_blank">
                                                                        <span class="mdi mdi-open-in-new"> Lihat Laporan</span> 
                                                                    </a>
                                                                @else
                                                                    <span class="text-muted">Belum diupload</span>
                                                                @endif

                                                                {{-- tombol nilai dan upload --}}
                                                                @if($dt->status_penilaian == 'belum')
                                                                    <a href="{{ route('proposal_final.penilaian', ['id' => $dt->id]) }}" class="btn btn-success">
                                                                        <span class="mdi mdi-trophy"> Beri Nilai</span> 
                                                                    </a>
                                                                @else
                                                                    @if($dt->status_scan_penilaian == 'belum')
                                                                        <a href="{{ route('proposal_final.penilaian', ['id' => $dt->id]) }}" class="btn btn-success">
                                                                            <span class="mdi mdi-pencil"> Edit Nilai</span> 
                                                                        </a>

                                                                        <a href="{{ route('proposal_final.uploadpenilaian', ['id' => $dt->id]) }}"  class="btn btn-success">
                                                                            <span class="mdi mdi-upload"> Upload Penilaian</span>
                                                                        </a>
                                                                    @endif

                                                                    @if($dt->status_scan_penilaian == 'sudah')
                                                                        <a href="{{ asset('storage/' . $dt->scan_penilaian) }}" class="btn btn-primary" target="_blank">
                                                                            <span class="mdi mdi-eye"> Lihat Nilai</span>
                                                                        </a>
                                                                        <a href="{{ route('proposal_final.uploadsertifikat', ['id' => $dt->id]) }}" class="btn btn-success">
                                                                            @if($dt->status_sertifikat == 'belum')
                                                                                <span class="mdi mdi-upload"> Upload Sertifikat</span>
                                                                            @else
                                                                                <span class="mdi mdi-upload"> Ganti Sertifikat</span> 
                                                                            @endif
                                                                        </a>
                                                                    @endif
                                                                @endif

                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-danger" role="alert">
                            Surat ini belum ditanggapi lembaga pendidikan pemohon!<br>
                            Tekan <i class="fa fa-fw fa-arrow-left"></i> untuk kembali ke halaman sebelumnya
                        </div>
                    @endif
                @else
                    <div class="alert alert-danger" role="alert">
                        Peserta magang belum ada!<br>
                        Tekan <i class="fa fa-fw fa-arrow-left"></i> untuk kembali ke halaman sebelumnya
                    </div>
                @endif
            @else
                <div class="alert alert-danger" role="alert">
                    Anda tidak memiliki akses ke halaman ini!<br>
                    Tekan <i class="fa fa-fw fa-arrow-left"></i> untuk kembali ke halaman sebelumnya
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
