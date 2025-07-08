<x-app-layout pageTitle="Daftar Penilai">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <x-breadcrumb pageTitle="Daftar Penilai" />
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">

            {{-- Notifikasi jika ada --}}
            @if (session('result') == 'success')
                <div class="alert alert-success">
                    Data petugas berhasil diperbarui
                </div>
            @endif

            <div class="card-header mb-3">
                <h1 class="card-title h1">DAFTAR PENILAI</h1>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    <form method="GET" action="{{ route('master_petugas') }}" class="d-flex ms-auto" style="max-width: 300px;">
                        <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control me-2" placeholder="Pencarian" style="font-size: 14px;">
                        <button type="submit" class="btn btn-secondary" style="font-size: 14px;">
                            <span class="mdi mdi-magnify"></span>
                        </button>
                    </form>
                </div>
                
                <div class="card-body table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>Pangkat</th>
                                <th>Golongan</th>
                                <th>Ruang</th>
                                <th>Jabatan</th>
                                <th>Bidang</th>
                                <th>Sub bidang</th>
                                <th class="text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $dt)
                                <tr>
                                    <td>{{ $dt->nama_pejabat }}</td>
                                    <td>{{ $dt->nip_pejabat }}</td>
                                    <td>{{ $dt->pangkat_pejabat }}</td>
                                    <td>{{ $dt->golongan_pejabat }}</td>
                                    <td>{{ $dt->ruang_pejabat }}</td>
                                    <td>{{ $dt->jabatan_pejabat }}</td>
                                    <td>{{ $dt->bidang->nama_bidang ?? '-' }}</td>
                                    <td>{{ $dt->sub_bidang_pejabat ?? '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('master_petugas.edit', $dt->member_id) }}" class="btn btn-primary btn-sm" title="Lihat Detail">
                                            <span class="mdi mdi-eye"></span>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted">Data penilai tidak ditemukan.</td>
                                </tr>
                            @endforelse
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
