<x-app-layout pageTitle="Status Administrasi">

    @section('content')
        <div class="p-6">

            <div class="mb-4 flex justify-between items-center">
                <div class="flex justify-between items-center mb-4">
                    <div class="text-gray-600">Beranda > <span class="font-medium text-gray-800">Status Administrasi</span>
                    </div>
                    <h2 class="text-2xl font-bold mb-4">Daftar Peserta Magang</h2>
                    
                </div>

                {{-- search --}}
                <div class="overflow-x-auto bg-white rounded-lg shadow border p-4">
                    <div class="d-flex dalign-items-center justify-content-end mb-1">
                        <form class="d-flex" role="search">
                            <input class="form-control rounded-pill me-2" type="search" placeholder="Search"
                                aria-label="Search" style="width: 180px;">

                                <button class="btn btn-outline-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                            </form>
                        </div>
                    </div>

                {{-- Tabel --}}
                        <table class="w-full table-auto text-sm text-left">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-4 py-3 border">Nama Lembaga Pendidikan</th>
                                    <th class="px-4 py-3 border">Data Lembaga Pendidikan</th>
                                    <th class="px-4 py-3 border">Narahubung</th>
                                    <th class="px-4 py-3 border">Status Administrasi</th>
                                </tr>
                            </thead>
                        <tbody class="text-gray-700">
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-3 border font-medium">
                                Institut Teknologi Sepuluh Nopember
                                </td>
                                <td class="px-4 py-3 border text-gray-600">
                                Kota Surabaya<br>(031) 5994251<br>its@mail.com
                                </td>
                                <td class="px-4 py-3 border text-gray-600">
                                Nabil Ishfaqqq<br>Pria<br>Koor Prodi<br>12345678
                            </td>
                            {{-- tombol button --}}
                            <td class="px-4 py-3 border">
                                <div class="d-flex  align-items-center">
                                    {{-- Status Badge --}}
                                    <button type="button" class="btn btn-outline-warning px-4 py-2 me-4"
                                        style="min-width: 100px;">Proses</button>

                                    {{-- Button Cek Detail --}}
                                    <button type="button" class="btn btn-outline-primary me-4 ">Cek Detail</button>
                                    {{-- Button hapuss --}}
                                    <button type="button" class="btn btn-outline-danger">
                                        <i class="mdi mdi-trash-can-outline"></i> Delete
                                    </button>
                                    
                                </div>
                            </td>
                        </tr>

                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-3 border font-medium">
                                Institut Teknologi Sepuluh Nopember
                            </td>
                            <td class="px-4 py-3 border text-gray-600">
                                Kota Surabaya<br>(031) 5994251<br>its@mail.com
                            </td>
                            <td class="px-4 py-3 border text-gray-600">
                                Nabil Ishfaqqq<br>Pria<br>Koor Prodi<br>12345678
                            </td>
                            {{-- tombol button --}}
                            <td class="px-4 py-3 border">
                                <div class="d-flex  align-items-center">
                                    {{-- Status Badge --}}
                                    <button type="button" class="btn btn-outline-success px-4 py-2 me-4"
                                        style="min-width: 100px;">Succes</button>

                                    {{-- Button Cek Detail --}}
                                    <button type="button" class="btn btn-outline-primary me-4 ">Cek Detail</button>
                                    {{-- Button hapuss --}}
                                    <button type="button" class="btn btn-outline-danger">
                                        <i class="mdi mdi-trash-can-outline"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-3 border font-medium">
                                Institut Teknologi Sepuluh Nopember
                            </td>
                            <td class="px-4 py-3 border text-gray-600">
                                Kota Surabaya<br>(031) 5994251<br>its@mail.com
                            </td>
                            <td class="px-4 py-3 border text-gray-600">
                                Nabil Ishfaqqq<br>Pria<br>Koor Prodi<br>12345678
                            </td>
                            {{-- tombol button --}}
                            <td class="px-4 py-3 border">
                                <div class="d-flex  align-items-center">
                                    {{-- Status Badge --}}
                                    <button type="button" class="btn btn-outline-warning px-4 py-2 me-4"
                                        style="min-width: 100px;">Proses</button>

                                    {{-- Button Cek Detail --}}
                                    <button type="button" class="btn btn-outline-primary me-4 ">Cek Detail</button>
                                    {{-- Button hapuss --}}
                                    <button type="button" class="btn btn-outline-danger">
                                        <i class="mdi mdi-trash-can-outline"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-3 border font-medium">
                                Institut Teknologi Sepuluh Nopember
                            </td>
                            <td class="px-4 py-3 border text-gray-600">
                                Kota Surabaya<br>(031) 5994251<br>its@mail.com
                            </td>
                            <td class="px-4 py-3 border text-gray-600">
                                Nabil Ishfaqqq<br>Pria<br>Koor Prodi<br>12345678
                            </td>
                            {{-- tombol button --}}
                            <td class="px-4 py-3 border">
                                <div class="d-flex  align-items-center">
                                    {{-- Status Badge --}}
                                    <button type="button" class="btn btn-outline-success px-4 py-2 me-4"
                                        style="min-width: 100px;">Succes</button>

                                    {{-- Button Cek Detail --}}
                                    <button type="button" class="btn btn-outline-primary me-4 ">Cek Detail</button>
                                    {{-- Button hapuss --}}
                                    <button type="button" class="btn btn-outline-danger">
                                        <i class="mdi mdi-trash-can-outline"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-3 border font-medium">
                                Institut Teknologi Sepuluh Nopember
                            </td>
                            <td class="px-4 py-3 border text-gray-600">
                                Kota Surabaya<br>(031) 5994251<br>its@mail.com
                            </td>
                            <td class="px-4 py-3 border text-gray-600">
                                Nabil Ishfaqqq<br>Pria<br>Koor Prodi<br>12345678
                            </td>
                            {{-- tombol button --}}
                            <td class="px-4 py-3 border">
                                <div class="d-flex  align-items-center">
                                    {{-- Status Badge --}}
                                    <button type="button" class="btn btn-outline-warning px-4 py-2 me-4"
                                        style="min-width: 100px;">Proses</button>

                                    {{-- Button Cek Detail --}}
                                    <button type="button" class="btn btn-outline-primary me-4 ">Cek Detail</button>
                                    {{-- Button hapuss --}}
                                    <button type="button" class="btn btn-outline-danger">
                                        <i class="mdi mdi-trash-can-outline"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </x-app-layout>
