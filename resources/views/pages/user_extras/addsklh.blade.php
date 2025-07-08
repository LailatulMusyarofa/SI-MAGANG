<x-app-layout pageTitle="Lengkapi Data!">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <x-breadcrumb pageTitle="Lengkapi Data"></x-breadcrumb>
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">
            @if (session('result') == 'success')
                <div class="alert alert-success">
                    Data berhasil disimpan!
                </div>
            @endif

            <form action="{{ route('user_extras.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Lengkapi data</h3>
                        <button type="submit" class="btn btn-primary text-white">
                            <span class="mdi mdi-content-save"> Simpan</span>
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            {{-- KIRI - Data Lembaga Pendidikan --}}
                            <div class="col-md-7">
                                <div class="card card-border mb-3">
                                    <div class="card-body">
                                        <h4 class="subheader mb-3">Data Lembaga Pendidikan</h4>

                                        <div class="mb-3">
                                            <label class="form-label">Jenis</label>
                                            <select class="form-select" name="jenis">
                                                <option value="sma">SMA/SMK/Madrasah Aliyah</option>
                                                <option value="pgt">Perguruan Tinggi</option>
                                                <option value="lpd">Lembaga Pendidikan</option>
                                                <option value="upt">UPT BLK Disnaker Prov. Jatim</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Alamat Lembaga Pendidikan</label>
                                            <input type="text" class="form-control" name="alamat"
                                                placeholder="Apabila diluar wilayah Jawa Timur, cukup diisi nama kabupaten/kota dan provinsi">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Kabupaten/Kota</label>
                                            <select class="form-select" name="kabko_sklh">
                                                <option value="provinsilainnya">Provinsi lainnya</option>
                                                <option value="Kabupaten Bangkalan">Kabupaten Bangkalan</option><!--Kabupaten Bangkalan-->
                                                <option value="Kabupaten Banyuwangi">Kabupaten Banyuwangi</option><!--Kabupaten Banyuwangi-->
                                                <option value="Kabupaten Blitar">Kabupaten Blitar</option><!--Kabupaten Blitar-->
                                                <option value="Kabupaten Bojonegoro">Kabupaten Bojonegoro</option><!--Kabupaten Bojonegoro-->
                                                <option value="Kabupaten Bondowoso">Kabupaten Bondowoso</option><!--Kabupaten Bondowoso-->
                                                <option value="Kabupaten Gresik">Kabupaten Gresik</option><!--Kabupaten Gresik-->
                                                <option value="Kabupaten Jember">Kabupaten Jember</option><!--Kabupaten Jember-->
                                                <option value="Kabupaten Jombang">Kabupaten Jombang</option><!--Kabupaten Jombang-->
                                                <option value="Kabupaten Kediri">Kabupaten Kediri</option><!--Kabupaten Kediri-->
                                                <option value="Kabupaten Lamongan">Kabupaten Lamongan</option><!--Kabupaten Lamongan-->
                                                <option value="Kabupaten Lumajang">Kabupaten Lumajang</option><!--Kabupaten Lumajang-->
                                                <option value="Kabupaten Madiun">Kabupaten Madiun</option><!--Kabupaten Madiun-->
                                                <option value="Kabupaten Magetan">Kabupaten Magetan</option><!--Kabupaten Magetan-->
                                                <option value="Kabupaten Malang">Kabupaten Malang</option><!--Kabupaten Malang-->
                                                <option value="Kabupaten Mojokerto">Kabupaten Mojokerto</option><!--Kabupaten Mojokerto-->
                                                <option value="Kabupaten Nganjuk">Kabupaten Nganjuk</option><!--Kabupaten Nganjuk-->
                                                <option value="Kabupaten Ngawi">Kabupaten Ngawi</option><!--Kabupaten Ngawi-->
                                                <option value="Kabupaten Pacitan">Kabupaten Pacitan</option><!--Kabupaten Pacitan-->
                                                <option value="Kabupaten Pamekasan">Kabupaten Pamekasan</option><!--Kabupaten Pamekasan-->
                                                <option value="Kabupaten Pasuruan">Kabupaten Pasuruan</option><!--Kabupaten Pasuruan-->
                                                <option value="Kabupaten Ponorogo">Kabupaten Ponorogo</option><!--Kabupaten Ponorogo-->
                                                <option value="Kabupaten Probolinggo">Kabupaten Probolinggo</option><!--Kabupaten Probolinggo-->
                                                <option value="Kabupaten Sampang">Kabupaten Sampang</option><!--Kabupaten Sampang-->
                                                <option value="Kabupaten Sidoarjo">Kabupaten Sidoarjo</option><!--Kabupaten Sidoarjo-->
                                                <option value="Kabupaten Situbondo">Kabupaten Situbondo</option><!--Kabupaten Situbondo-->
                                                <option value="Kabupaten Sumenep">Kabupaten Sumenep</option><!--Kabupaten Sumenep-->
                                                <option value="Kabupaten Trenggalek">Kabupaten Trenggalek</option><!--Kabupaten Trenggalek-->
                                                <option value="Kabupaten Tuban">Kabupaten Tuban</option><!--Kabupaten Tuban-->
                                                <option value="Kabupaten Tulungagung">Kabupaten Tulungagung</option><!--Kabupaten Tulungagung-->
                                                <option value="Kota Batu">Kota Batu</option><!--Kota Batu-->
                                                <option value="Kota Blitar">Kota Blitar</option><!--Kota Blitar-->
                                                <option value="Kota Kediri">Kabupaten Kediri</option><!--Kota Kediri-->
                                                <option value="Kota Madiun">Kota Madiun</option><!--Kota Madiun-->
                                                <option value="Kota Malang">Kota Malang</option><!--Kota Malang-->
                                                <option value="Kota Mojokerto">Kota Mojokerto</option><!--Kota Mojokerto-->
                                                <option value="Kota Pasuruan">Kota Pasuruan</option><!--Kota Pasuruan-->
                                                <option value="Kota Probolinggo">Kota Probolinggo</option><!--Kota Probolinggo-->
                                                <option value="Kota Surabaya">Kota Surabaya</option><!--Kota Surabaya-->
                                                </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">No. Telepon Lembaga Pendidikan</label>
                                            <input type="text" class="form-control" name="telepon_lembaga"
                                                placeholder="Nomor telepon Lembaga Pendidikan">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Jenis Akreditasi</label>
                                            <select class="form-select" name="akreditasi">
                                                <option value="a">Unggul (A)</option>
                                                <option value="b">Baik Sekali (B)</option>
                                                <option value="c">Baik (C)</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">No. Akreditasi Lembaga Pendidikan</label>
                                            <input type="text" class="form-control" name="no_akreditasi"
                                                placeholder="Nomor Akreditasi">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">File Surat Akreditasi (.jpg/.pdf, max. 10MB)</label>
                                            <input name="file_akreditasi" type="file" class="form-control" accept=".pdf,.jpg,.jpeg">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- KANAN - Data Narahubung --}}
                            <div class="col-md-5">
                                <div class="card card-border mb-3">
                                    <div class="card-body">
                                        <h4 class="subheader mb-3">Data Narahubung</h4>

                                        <div class="mb-3">
                                            <label class="form-label">Nama</label>
                                            <input type="text" class="form-control" name="nama_narahubung"
                                                placeholder="Masukkan nama narahubung disini">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Jenis Kelamin</label>
                                            <select class="form-select" name="jenis_kelamin">
                                                <option value="Pria">Pria</option>
                                                <option value="Wanita">Wanita</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Jabatan</label>
                                            <input type="text" class="form-control" name="jabatan_narahubung"
                                                placeholder="Masukkan jabatan narahubung disini">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Telepon</label>
                                            <input type="text" class="form-control" name="telepon_narahubung"
                                                placeholder="Masukkan nomor handphone narahubung disini">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> {{-- end row --}}
                    </div> {{-- end card-body --}}
                </div> {{-- end card --}}
            </form>
        </div>
    </div>
</x-app-layout>
