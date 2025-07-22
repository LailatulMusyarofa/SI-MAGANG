<x-app-layout pageTitle="Status Administrasi">
 
    <table class="table table-bordered text-sm">
        <thead class="bg-gray-200 text-gray-700">
            <tr>
                <th class="px-4 py-2 border">Nama</th>
                <th class="px-4 py-2 border">Data Lembaga Pendidikan</th>
                <th class="px-4 py-2 border">Narahubung</th>
                <th class="px-4 py-2 border">Status Administrasi</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            @foreach ($data as $item)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-3 border font-medium">{{ $item->nama_lembaga }}</td>
                    <td class="px-4 py-3 border text-gray-600">
                        {{ $item->alamat }}<br>{{ $item->kontak }}<br>{{ $item->email }}
                    </td>
                    <td class="px-4 py-3 border text-gray-600">
                        {{ $item->narahubung }}<br>{{ $item->jenis_kelamin }}<br>{{ $item->jabatan }}<br>{{ $item->no_hp }}
                    </td>
                    <td class="px-4 py-3 border">
                        <div class="d-flex align-items-center">
                            <span class="btn btn-outline-warning px-3 py-1 me-2" style="min-width: 100px;">
                                {{ ucfirst($item->status_pengajuan) }}
                            </span>
                            <form action="{{ route('master_administrasi.edit', $item->id) }}" method="GET" class="me-2">
                                <button type="submit" class="btn btn-outline-primary btn-sm">Cek Detail</button>
                            </form>
                            <form method="POST" action="{{ route('master_administrasi.destroy', $item->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="mdi mdi-trash-can-outline"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
