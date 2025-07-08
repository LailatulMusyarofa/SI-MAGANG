<x-app-layout pageTitle="Edit Permohonan Keluar">
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
                        <li class="breadcrumb-item">
                            <a href="{{ route('user.viewpermohonankeluar', ['id' => $permohonan->id]) }}">Detail Permohonan</a>
                        </li>
                        <li class="breadcrumb-item muted" aria-current="page">
                            Edit Permohonan
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">
            <form method="POST" action="{{ route('user.updatepermohonankeluar', ['id' => $permohonan->id]) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Permohonan Keluar</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="nomor_surat_permintaan">Nomor Surat</label>
                            <input type="text" name="nomor_surat_permintaan" class="form-control" value="{{ old('nomor_surat_permintaan', $permohonan->nomor_surat_permintaan) }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="tanggal_surat_permintaan">Tanggal Surat</label>
                            <input type="date" name="tanggal_surat_permintaan" class="form-control" value="{{ old('tanggal_surat_permintaan', $permohonan->tanggal_surat_permintaan) }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="perihal_surat_permintaan">Perihal Surat</label>
                            <input type="text" name="perihal_surat_permintaan" class="form-control" value="{{ old('perihal_surat_permintaan', $permohonan->perihal_surat_permintaan) }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="ditandatangani_oleh">Ditandatangani Oleh</label>
                            <input type="text" name="ditandatangani_oleh" class="form-control" value="{{ old('ditandatangani_oleh', $permohonan->ditandatangani_oleh) }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="scan_surat_permintaan">Scan Surat Permintaan</label>
                            <input type="file" name="scan_surat_permintaan" class="form-control">
                            @if($permohonan->scan_surat_permintaan)
                                <small>File saat ini: 
                                    <a href="{{ asset('storage/' . $permohonan->scan_surat_permintaan) }}" target="_blank" class="text-primary">
                                        {{ basename($permohonan->scan_surat_permintaan) }}
                                    </a>
                                </small>
                            @endif
                        </div>
                        <div class="form-group mb-4">
                            <label for="scan_proposal_magang">Scan Proposal Magang</label>
                            <input type="file" name="scan_proposal_magang" class="form-control">
                            @if($permohonan->scan_proposal_magang)
                                <small>File saat ini: 
                                    <a href="{{ asset('storage/' . $permohonan->scan_proposal_magang) }}" target="_blank" class="text-primary">
                                        {{ basename($permohonan->scan_proposal_magang) }}
                                    </a>
                                </small>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
