<x-app-layout pageTitle="Form Permohonan Magang">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <x-breadcrumb pageTitle="Buat Permohonan" />
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">

            @if(Auth::user()->akun_diverifikasi != 'sudah')
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <div class="alert-icon me-2">
                        <span class="mdi mdi-alert-circle-outline" style="font-size: 24px;"></span>
                    </div>
                    <div>
                        <h4 class="alert-heading mb-1">Perhatian!</h4>
                        <div class="alert-description">
                            Akun Anda belum diverifikasi oleh admin.
                        </div>
                    </div>
                </div>
            @else
                @if (session('result') == 'success')
                    <div class="alert alert-success">Data berhasil disimpan!</div>
                @endif

                <form action="{{ route('user_extras.simpan_proposal') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Form Permohonan Magang</h3>
                            <button type="submit" class="btn btn-primary text-white">
                                <span class="mdi mdi-send"> Kirim</span>
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card card-border mb-3">
                                        <div class="card-body">

                                            <div class="mb-3">
                                                <label for="iNomorSuratPermintaan">Nomor Surat</label>
                                                <input type="text" 
                                                    name="nomor_surat_permintaan" 
                                                    id="iNomorSuratPermintaan"
                                                    class="form-control @error('nomor_surat_permintaan') is-invalid @enderror" 
                                                    value="{{ old('nomor_surat_permintaan') }}" 
                                                    placeholder="Masukkan nomor surat disini">
                                                @error('nomor_surat_permintaan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="iTanggalSuratPermintaan">Tanggal Surat</label>
                                                <input type="date"
                                                    name="tanggal_surat_permintaan"
                                                    id="iTanggalSuratPermintaan"
                                                    class="form-control @error('tanggal_surat_permintaan') is-invalid @enderror"
                                                    value="{{ old('tanggal_surat_permintaan') }}"
                                                    required>
                                                @error('tanggal_surat_permintaan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="iPerihalSuratPermintaan">Perihal</label>
                                                <input type="text" 
                                                    name="perihal_surat_permintaan" 
                                                    id="iPerihalSuratPermintaan"
                                                    class="form-control @error('perihal_surat_permintaan') is-invalid @enderror" 
                                                    value="{{ old('perihal_surat_permintaan') }}" 
                                                    placeholder="Masukkan perihal disini">
                                                @error('perihal_surat_permintaan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="iDitandatanganiOleh">Ditandatangani Oleh</label>
                                                <input type="text" 
                                                    name="ditandatangani_oleh" 
                                                    id="iDitandatanganiOleh"
                                                    class="form-control @error('ditandatangani_oleh') is-invalid @enderror" 
                                                    value="{{ old('ditandatangani_oleh') }}" 
                                                    placeholder="Catatan: diisi jabatan, bukan nama orangnya">
                                                @error('ditandatangani_oleh')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="file_surat_permintaan">Scan Surat Permintaan (.jpg, .pdf, max 10MB)</label>
                                                <input 
                                                    type="file"
                                                    name="file_surat_permintaan"
                                                    id="file_surat_permintaan"
                                                    accept=".pdf,.jpg,.jpeg,.png"
                                                    class="form-control @error('file_surat_permintaan') is-invalid @enderror">
                                                @error('file_surat_permintaan')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="file_proposal_magang">Scan Proposal Magang (.jpg, .pdf, max 10MB)</label>
                                                <input 
                                                    type="file"
                                                    name="file_proposal_magang"
                                                    id="file_proposal_magang"
                                                    accept=".pdf,.jpg,.jpeg,.png"
                                                    class="form-control @error('file_proposal_magang') is-invalid @enderror">
                                                @error('file_proposal_magang')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div> {{-- end row --}}
                        </div> {{-- end card-body --}}
                    </div> {{-- end card --}}
                </form>
            @endif

        </div>
    </div>
</x-app-layout>
