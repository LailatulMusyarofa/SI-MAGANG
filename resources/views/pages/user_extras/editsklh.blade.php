<x-app-layout pageTitle="Edit Data!">
    <x-page-header>
        <div class="container-xl">   
            <div class="row g-2 align-items-center">
                <x-breadcrumb pageTitle="Edit Data"></x-breadcrumb>
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">
            @if (session('result') == 'success')
                <div class="alert alert-success">
                    Data berhasil diperbarui!
                </div>
            @endif

            <form action="{{ route('user_extras.updatesklh') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Edit Data</h3>
                        <button type="submit" class="btn btn-primary text-white">
                            <span class="mdi mdi-content-save"> Simpan</span>
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            {{-- KIRI --}}
                            <div class="col-md-7">
                                <div class="card card-border mb-3">
                                    <div class="card-body">
                                        <h4 class="subheader mb-3">Data Lembaga Pendidikan</h4>

                                        <div class="mb-3">
                                            <label class="form-label">Jenis</label>
                                            <select class="form-select" name="jenis_sklh">
                                                @foreach(['sma' => 'SMA/SMK/Madrasah Aliyah', 'pgt' => 'Perguruan Tinggi', 'lpd' => 'Lembaga Pendidikan', 'upt' => 'UPT BLK Disnaker Prov. Jatim'] as $key => $label)
                                                    <option value="{{ $key }}" {{ old('jenis_sklh', $dt->jenis_sklh) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Alamat Lembaga Pendidikan</label>
                                            <input type="text" class="form-control" name="alamat_sklh" value="{{ old('alamat_sklh', $dt->alamat_sklh) }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Kabupaten/Kota</label>
                                            <select class="form-select" name="kabko_sklh">
                                                @foreach([
                                                    'provinsilainnya' => 'Provinsi lainnya',
                                                    'Kabupaten Bangkalan',
                                                    'Kabupaten Banyuwangi',
                                                    'Kabupaten Blitar',
                                                    'Kabupaten Bojonegoro',
                                                    'Kabupaten Bondowoso',
                                                    'Kabupaten Gresik',
                                                    'Kabupaten Jember',
                                                    'Kabupaten Jombang',
                                                    'Kabupaten Kediri',
                                                    'Kabupaten Lamongan',
                                                    'Kabupaten Lumajang',
                                                    'Kabupaten Madiun',
                                                    'Kabupaten Magetan',
                                                    'Kabupaten Malang',
                                                    'Kabupaten Mojokerto',
                                                    'Kabupaten Nganjuk',
                                                    'Kabupaten Ngawi',
                                                    'Kabupaten Pacitan',
                                                    'Kabupaten Pamekasan',
                                                    'Kabupaten Pasuruan',
                                                    'Kabupaten Ponorogo',
                                                    'Kabupaten Probolinggo',
                                                    'Kabupaten Sampang',
                                                    'Kabupaten Sidoarjo',
                                                    'Kabupaten Situbondo',
                                                    'Kabupaten Sumenep',
                                                    'Kabupaten Trenggalek',
                                                    'Kabupaten Tuban',
                                                    'Kabupaten Tulungagung',
                                                    'Kota Batu',
                                                    'Kota Blitar',
                                                    'Kota Kediri',
                                                    'Kota Madiun',
                                                    'Kota Malang',
                                                    'Kota Mojokerto',
                                                    'Kota Pasuruan',
                                                    'Kota Probolinggo',
                                                    'Kota Surabaya'
                                                ] as $k)
                                                    <option value="{{ $k }}" {{ old('kabko_sklh', $dt->kabko_sklh) == $k ? 'selected' : '' }}>{{ $k }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">No. Telepon Lembaga Pendidikan</label>
                                            <input type="text" class="form-control" name="telp_sklh" value="{{ old('telp_sklh', $dt->telp_sklh) }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Jenis Akreditasi</label>
                                            <select class="form-select" name="akreditasi_sklh">
                                                @foreach(['a' => 'Unggul (A)', 'b' => 'Baik Sekali (B)', 'c' => 'Baik (C)'] as $key => $label)
                                                    <option value="{{ $key }}" {{ old('akreditasi_sklh', $dt->akreditasi_sklh) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">No. Akreditasi Lembaga Pendidikan</label>
                                            <input type="text" class="form-control" name="no_akreditasi_sklh" value="{{ old('no_akreditasi_sklh', $dt->no_akreditasi_sklh) }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">File Surat Akreditasi</label>
                                            <input name="scan_surat_akreditasi_sklh" type="file" class="form-control" accept=".pdf,.jpg,.jpeg">
                                            @if($dt->scan_surat_akreditasi_sklh)
                                                <small class="text-muted">
                                                    File saat ini: 
                                                    <a href="{{ asset('storage/' . $dt->scan_surat_akreditasi_sklh) }}" target="_blank" style="text-decoration: underline;">
                                                        {{ basename($dt->scan_surat_akreditasi_sklh) }}
                                                    </a>
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- KANAN --}}
                            <div class="col-md-5">
                                <div class="card card-border mb-3">
                                    <div class="card-body">
                                        <h4 class="subheader mb-3">Data Narahubung</h4>

                                        <div class="mb-3">
                                            <label class="form-label">Nama</label>
                                            <input type="text" class="form-control" name="nama_narahubung" value="{{ old('nama_narahubung', $dt->nama_narahubung) }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Jenis Kelamin</label>
                                            <select class="form-select" name="jenis_kelamin_narahubung">
                                                <option value="Pria" {{ old('jenis_kelamin_narahubung', $dt->jenis_kelamin_narahubung) == 'Pria' ? 'selected' : '' }}>Pria</option>
                                                <option value="Wanita" {{ old('jenis_kelamin_narahubung', $dt->jenis_kelamin_narahubung) == 'Wanita' ? 'selected' : '' }}>Wanita</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Jabatan</label>
                                            <input type="text" class="form-control" name="jabatan_narahubung" value="{{ old('jabatan_narahubung', $dt->jabatan_narahubung) }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Telepon</label>
                                            <input type="text" class="form-control" name="handphone_narahubung" value="{{ old('handphone_narahubung', $dt->handphone_narahubung) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> {{-- end row --}}
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
