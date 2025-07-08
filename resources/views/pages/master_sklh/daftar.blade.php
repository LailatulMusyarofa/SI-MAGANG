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
            @if (session('result'))
                <div class="alert alert-success">
                    {{ session('result') }}
                </div>
            @endif

            <div class="card-header mb-3">
                <h1 class="card-title h1">DAFTAR LEMBAGA PENDIDIKAN</h1>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <form method="GET" action="{{ route('master_sklh') }}" class="d-flex ms-auto" style="max-width: 300px;">
                        <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control me-2" placeholder="Pencarian">
                        <button type="submit" class="btn btn-secondary">
                            <span class="mdi mdi-magnify"></span>
                        </button>
                    </form>
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-hover table-bordered">
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
                                        <a target="_blank" href="{{ asset('storage/' . $dt->scan_surat_akreditasi_sklh) }}">
                                            Surat Akreditasi
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
                                                <td><span class="mdi mdi-gender-male-female"></span></td>
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
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#verify_{{ $dt->id }}">
                                                <span class="mdi mdi-check-bold"></span>
                                            </button>
                                        @elseif ($status == 'sudah')
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#suspend_{{ $dt->id }}">
                                                <span class="mdi mdi-close-thick"></span>
                                            </button>
                                        @elseif ($status == 'suspended')
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#unlock_{{ $dt->id }}">
                                                <span class="mdi mdi-lock-open"></span>
                                            </button>
                                        @endif

                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete_{{ $dt->id }}">
                                            <span class="mdi mdi-delete"></span>
                                        </button>

                                        <a href="{{ route('master_sklh.edit', ['id' => $dt->id]) }}" class="btn btn-primary">
                                            <span class="mdi mdi-eye"></span>
                                        </a>

                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reset_{{ $dt->id }}">
                                            Reset Password
                                        </button>
                                    </td>
                                </tr>

                                <!-- MODAL VERIFIKASI -->
                                <form action="{{ route('master_sklh.verification', ['id' => $dt->id]) }}" method="post">
                                    @csrf
                                    @method('POST')
                                    <div class="modal fade" id="verify_{{ $dt->id }}" tabindex="-1" aria-labelledby="verifyLabel_{{ $dt->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="verifyLabel_{{ $dt->id }}">Verifikasi Lembaga</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Yakin ingin memverifikasi <strong>{{ $dt->fullname }}</strong>?
                                                    <input type="hidden" name="id" value="{{ $dt->id }}">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-success">Verifikasi</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- MODAL DELETE -->
                                <form action="{{ route('master_sklh.delete', ['id' => $dt->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal fade" id="delete_{{ $dt->id }}" tabindex="-1" aria-labelledby="deleteLabel_{{ $dt->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteLabel_{{ $dt->id }}">Hapus Lembaga</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Yakin ingin menghapus <strong>{{ $dt->fullname }}</strong>?
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
                                <!-- MODAL SUSPEND -->
<form action="{{ route('master_sklh.suspend', ['id' => $dt->id]) }}" method="post">
    @csrf
    @method('POST')
    <div class="modal fade" id="suspend_{{ $dt->id }}" tabindex="-1" aria-labelledby="suspendLabel_{{ $dt->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="suspendLabel_{{ $dt->id }}">Suspend Lembaga</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Yakin ingin menangguhkan <strong>{{ $dt->fullname }}</strong>? 
                    <input type="hidden" name="id" value="{{ $dt->id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Suspend</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- MODAL UNLOCK -->
<form action="{{ route('master_sklh.unlock', ['id' => $dt->id]) }}" method="post">
    @csrf
    @method('POST')
    <div class="modal fade" id="unlock_{{ $dt->id }}" tabindex="-1" aria-labelledby="unlockLabel_{{ $dt->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="unlockLabel_{{ $dt->id }}">Buka Blokir Akun</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Yakin ingin membuka blokir akun <strong>{{ $dt->fullname }}</strong>? 
                    <input type="hidden" name="id" value="{{ $dt->id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Buka Blokir</button>
                </div>
            </div>
        </div>
    </div>
</form>


                            @endforeach
                            @if($data->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Data lembaga pendidikan tidak ditemukan.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-center">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>