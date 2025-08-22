<x-app-layout pageTitle="Status Administrasi">
    <div class="card-header mb-3">
        <h1 class="card-title h1">DAFTAR ADMINISTRASI</h1>
    </div>

    <div class="card mb-4">
        {{-- Tombol Tambah & Pencarian --}}
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            {{-- <a href="{{ route('master_administrasi.create') }}" class="btn btn-outline-success btn-sm">
                <i class="fas fa-plus"></i> Tambah Peserta
            </a> --}}

            <form method="GET" action="{{ route('master_sklh') }}" class="d-flex ms-auto" style="max-width: 300px;">
                <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control me-2" placeholder="Pencarian">
                <button type="submit" class="btn btn-secondary">
                    <span class="mdi mdi-magnify"></span>
                </button>
            </form>
        </div>

        {{-- Tabel Data --}}
        <div class="card-body">
            <table class="table table-bordered text-sm">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 border">Nama</th>
                        <th class="px-4 py-2 border">Narahubung</th> 
                        <th class="px-4 py-2 border">Status Administrasi</th>
                        <th class="px-4 py-2 border">Opsi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach ($data as $item)
                        <tr class="border-t hover:bg-gray-50">                            
                            {{-- Nama Lembaga --}}
                            <td class="px-4 py-3 border font-medium">{{ $item->nama_lembaga }}</td>

                            {{-- Detail Narahubung --}}
                            <td class="px-4 py-3 border text-gray-600">
                                {{ $item->narahubung }}<br>
                                {{ ucfirst($item->jenis_kelamin) }}<br>
                                {{ $item->jabatan }}<br>
                                {{ $item->no_hp }}
                            </td>

                            {{-- Status Pengajuan dengan Warna --}}
                            <td class="px-4 py-3 border">
                                @php
                                    $status = strtolower($item->status_pengajuan);
                                    $warna = match ($status) {
                                        'sukses'         => 'success',
                                        'proses'         => 'warning',
                                        'belum diproses' => 'danger',
                                        default          => 'secondary',
                                    };
                                @endphp
                            
                                <span class="btn btn-{{ $warna }} px-3 py-1" style="min-width: 100px;">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            

                            {{-- Opsi Aksi --}}
                            <td class="px-4 py-3 border">
                                <div class="d-flex flex-wrap gap-2">
                                    {{-- Tombol Edit / Detail --}}
                                    <form action="{{ route('master_administrasi.view', $item->id) }}" method="GET">
                                        <button type="submit" class="btn btn-outline-primary btn-sm">Cek Detail</button>
                                    </form>

                                    {{-- Tombol Hapus --}}
                                    <form method="POST" action="{{ route('master_administrasi.destroy', $item->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="mdi mdi-trash-can-outline"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
