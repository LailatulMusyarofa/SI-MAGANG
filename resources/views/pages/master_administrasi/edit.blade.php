<x-app-layout pageTitle="Edit Status Administrasi">

    <form action="{{ route('master_administrasi.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nama_lembaga" class="form-label">Nama Lembaga</label>
            <input type="text" name="nama_lembaga" id="nama_lembaga" class="form-control" value="{{ $item->nama_lembaga }}" required>
        </div>

        <div class="mb-4">
            <label for="status_pengajuan" class="form-label">Status Pengajuan</label>
            <select name="status_pengajuan" id="status_pengajuan" class="form-select" required>
                <option value="belum diproses" {{ $item->status_pengajuan == 'belum diproses' ? 'selected' : '' }}>Belum Diproses</option>
                <option value="proses" {{ $item->status_pengajuan == 'proses' ? 'selected' : '' }}>Proses</option>
                <option value="sukses" {{ $item->status_pengajuan == 'sukses' ? 'selected' : '' }}>Sukses</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('master_administrasi') }}" class="btn btn-secondary">Kembali</a>
    </form>

</x-app-layout>
