<x-app-layout pageTitle="Detail Data">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <x-breadcrumb pageTitle="Detail Data"></x-breadcrumb>
            </div>
        </div>
    </x-page-header>



    <div class="page-body">
        <div class="container-xl">
             @if (session('result'))
                <div class="alert alert-success">
                    {{ session('result') }}
                </div>
            @endif
            
            @if(Auth::user()->role_id == 2 && $dt->id_user == Auth::user()->id)
                <div class="space-y-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-xl font-semibold d-flex align-items-center">
                                Detail Data
                                <a class="btn btn-success text-white ms-3" href="{{ route('edit_data') }}" style="height: 32px; padding: 0 12px; font-size: 14px;">
                                    <span class="mdi mdi-square-edit-outline"></span>
                                </a>
                            </h3>

                            {{-- Notifikasi --}}
                            @if(session('result') == 'update')
                                <div class="alert alert-success" role="alert">
                                    <strong>Berhasil!</strong> Data berhasil diperbaharui.
                                </div>
                            @endif

                            @if(session('result') == 'fail-delete')
                                <div class="alert alert-danger" role="alert">
                                    <strong>Gagal!</strong> Data gagal dihapus.
                                </div>
                            @endif

                            <div class="row row-deck">
                                {{-- Kolom Kiri --}}
                                <div class="col-md-6 d-flex flex-column gap-3">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Data Lembaga Pendidikan</h3>
                                        </div>
                                        <div class="card-body">
                                            <dl>
                                                <dt>Nama</dt>
                                                <dd>{{ $dt->user->fullname }}</dd>
                                                <dt>Alamat</dt>
                                                <dd>{{ $dt->alamat_sklh }}</dd>
                                                <dt>Kabupaten/Kota</dt>
                                                <dd>{{ $dt->kabko_sklh != 'provinsilainnya' ? $dt->kabko_sklh : 'Provinsi Lainnya' }}</dd>
                                                <dt>Telepon</dt>
                                                <dd>{{ $dt->telp_sklh }}</dd>
                                                <dt>Email</dt>
                                                <dd>{{ $dt->email }}</dd>
                                            </dl>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="card-title">Data Akreditasi</h3>
                                        </div>
                                        <div class="card-body">
                                            <dl>
                                                <dt>Akreditasi</dt>
                                                <dd>
                                                    {{ ucwords(match($dt->akreditasi_sklh) {
                                                        'a' => 'Unggul (A)',
                                                        'b' => 'Baik Sekali (B)',
                                                        'c' => 'Baik (C)',
                                                    }) }}
                                                </dd>
                                                <dt>Nomor Akreditasi</dt>
                                                <dd>{{ $dt->no_akreditasi_sklh }}</dd>
                                                <dt class="font-semibold">File Surat Akreditasi</dt>
                                                <dd class="mb-2">
                                                    @if($dt->scan_surat_akreditasi_sklh)
                                                         <a href="{{ asset('storage/' . $dt->scan_surat_akreditasi_sklh) }}" target="_blank" style="text-decoration: underline; color: blue;">
                                                            {{ basename($dt->scan_surat_akreditasi_sklh) }}
                                                        </a>
                                                    @else
                                                        <span>Tidak ada file tersedia.</span>
                                                    @endif
                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>

                                {{-- Kolom Kanan --}}
                                <div class="col-md-6">
                                    <div class="card h-50">
                                        <div class="card-header">
                                            <h3 class="card-title">Narahubung</h3>
                                        </div>
                                        <div class="card-body">
                                            <dl>
                                                <dt>Nama</dt>
                                                <dd>{{ $dt->nama_narahubung }}</dd>
                                                <dt>Jenis Kelamin</dt>
                                                <dd>{{ ucwords($dt->jenis_kelamin_narahubung) }}</dd>
                                                <dt>Jabatan</dt>
                                                <dd>{{ $dt->jabatan_narahubung }}</dd>
                                                <dt>No. Handphone</dt>
                                                <dd>{{ $dt->handphone_narahubung }}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @else
                <div class="bg-red-100 border border-red-400 text-red-800 p-6 rounded-lg mt-6">
                    <h3 class="text-2xl font-semibold mb-2">Akses Ditolak!</h3>
                    <p>Anda tidak diizinkan untuk mengakses halaman ini.</p>
                    <p class="mt-2">Tekan <i class="fa fa-fw fa-arrow-left"></i> untuk kembali ke halaman sebelumnya.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
