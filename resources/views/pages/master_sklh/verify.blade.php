<x-app-layout pageTitle="Daftar Lembaga Pendidikan">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <x-breadcrumb pageTitle="Daftar Lembaga Pendidikan" />
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">
            {{-- Notifikasi jika ada --}}
            @if (session('result') == 'success')
                <div class="alert alert-success">
                    Data berhasil disimpan.
                </div>
            @endif

            <div class="card-header mb-3">
                <h1 class="card-title h1">DAFTAR LEMBAGA PENDIDIKAN</h1>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <form method="GET" action="{{ route('master_sklh') }}" class="ms-auto" style="max-width: 300px;">
                        <div class="input-icon">
                            <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control" placeholder="Search…">
                            <span class="input-icon-addon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search"
                                     width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                     stroke="currentColor" fill="none" stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                    <path d="M21 21l-6 -6"></path>
                                </svg>
                            </span>
                        </div>
                    </form>
                </div>

            {{-- Detil Data Lembaga Pendidikan --}}
            <div class="box-body table-responsive no-padding">
                <table class="table table-head-fixed table-hover">
                    <thead>
                        <tr>
                            <th>NAMA LEMBAGA PENDIDIKAN</th>
                            <th>DATA LEMBAGA PENDIDIKAN</th>
                            <th>AKREDITASI</th>
                            <th>NARAHUBUNG</th>
                            <th>STATUS</th>
                            <th>OPSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $dt)
                            <tr>
                                <td>{{ $dt->fullname }}</td>

                                <td>
                                    <table>
                                        <tr>
                                            <td><span class="mdi mdi-map-marker"></span></td>
                                            <td width="5pt"></td>
                                            <td>{{ $dt->kabko_sklh == 'provinsilainnya' ? 'Provinsi Lainnya' : $dt->kabko_sklh }}</td>
                                        </tr>
                                        <tr>
                                            <td><span class="mdi mdi-phone"></span></td>
                                            <td width="5pt"></td>
                                            <td>{{ $dt->telp_sklh }}</td>
                                        </tr>
                                        <tr>
                                            <td><i class="mdi mdi-email"></i></td>
                                            <td width="5pt"></td>
                                            <td>{{ $dt->user->email ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </td>

                                <td>
                                    @php
                                        $akreditasi = ['a' => 'Unggul (A)', 'b' => 'Baik Sekali (B)', 'c' => 'Baik (C)'];
                                    @endphp
                                    {{ $akreditasi[$dt->akreditasi_sklh] ?? '-' }}
                                    <br>
                                    <a target="_blank"
                                       href="{{ asset('storage/scan_surat_akreditasi_sklh/' . $dt->scan_surat_akreditasi_sklh) }}">
                                       Surat akreditasi
                                    </a>
                                </td>

                                <td>
                                    <table>
                                        <tr>
                                            <td><span class="mdi mdi-account"></span></td>
                                            <td width="5pt"></td>
                                            <td>{{ $dt->nama_narahubung }}</td>
                                        </tr>
                                        <tr>
                                            <td><span class="mdi mdi-gender-male-female-variant"></span></td>
                                            <td width="5pt"></td>
                                            <td>{{ ucfirst($dt->jenis_kelamin_narahubung) }}</td>
                                        </tr>
                                        <tr>
                                            <td><span class="mdi mdi-briefcase-variant"></span></td>
                                            <td width="5pt"></td>
                                            <td>{{ $dt->jabatan_narahubung }}</td>
                                        </tr>
                                        <tr>
                                            <td><span class="mdi mdi-phone"></span></td>
                                            <td width="5pt"></td>
                                            <td>{{ $dt->handphone_narahubung }}</td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    @if ($dt->akun_diverifikasi == 'belum')
                                        Belum diverifikasi
                                    @elseif($dt->akun_diverifikasi == 'sudah')
                                        Sudah diverifikasi
                                    @elseif($dt->akun_diverifikasi == 'suspended')
                                        Ditangguhkan
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $status = $dt->user->akun_diverifikasi;
                                    @endphp

                                    @if ($status == 'belum')
                                        <a href="#verify_{{ $dt->id }}" class="btn btn-sm btn-success btn-verify" data-toggle="modal" data-target="#verify_{{ $dt->id }}"
                                            style="line-height: 1; min-height: auto; height: auto;">
                                            <span class="mdi mdi-check-bold"></span>
                                        </a>
                                    @elseif ($status == 'sudah')
                                        <a href="#" class="btn btn-sm btn-danger btn-suspend" data-toggle="modal" data-target="#suspend_{{ $dt->id }}"
                                            style="line-height: 1; min-height: auto; height: auto;">
                                            <span class="mdi mdi-close-thick" style="font-size: 10px;"></span>
                                        </a>
                                    @elseif ($status == 'suspended')
                                        <a href="#" class="btn btn-sm btn-primary btn-unlock" data-toggle="modal" data-target="#unlock_{{ $dt->id }}"
                                            style="line-height: 1; min-height: auto; height: auto;">
                                            <span class="mdi mdi-lock-open" style="font-size: 10px;"></span>
                                        </a>
                                    @endif
                                    <button data-target="#delete_{{ $dt->id }}" data-toggle="modal" type="button"
                                        class="btn btn-sm btn-danger btn-trash">
                                        <span class="mdi mdi-delete"></span>
                                    </button>

                                    <a href="{{ route('master_sklh.edit', ['id' => $dt->id]) }}" class="btn btn-primary btn-sm">
                                        <span class="mdi mdi-eye"></span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        @if($data->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center text-muted">Data lembaga pendidikan tidak ditemukan.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
