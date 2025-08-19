<x-app-layout pageTitle="Tambah Administrasi">
    <div class="card">
        <div class="card-header">
            <h2>Tambah Data Administrasi</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('master_administrasi.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Nama Lembaga</label>
                    <input type="text" name="nama_lembaga" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Kontak</label>
                    <input type="text" name="kontak" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Narahubung</label>
                    <input type="text" name="narahubung" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="Pria">Pria</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Jabatan</label>
                    <input type="text" name="jabatan" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>No HP</label>
                    <input type="text" name="no_hp" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Status Administrasi</label>
                    <select name="status_pengajuan" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="belum diproses">Belum diproses</option>
                        <option value="proses">Proses</option>
                        <option value="sukses">Sukses</option>
                    </select>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('master_administrasi') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
