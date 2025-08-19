<x-app-layout pageTitle="Home">
    <!-- Header -->
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <!-- Breadcrumb -->
                <x-breadcrumb pageTitle="Beranda" />

                <!-- Notifikasi -->
                <div class="col-auto ms-auto d-flex align-items-center">
                    <ul class="navbar-nav">
                        @include('pages.home.fitur.notifikasi')
                    </ul>
                </div>
            </div>
        </div>
    </x-page-header>

    <!-- Page Body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row justify-content-center">
                <div class="col-12 col-md-12 col-lg-11">
                    <div class="d-block">
                        <!-- Header Selamat Datang -->
                        <div class="col-12 bg-light p-7 rounded">
                            <h1 class="fw-bold fst-italic mb-4" style="font-size: 2.5rem;">Selamat Datang</h1>
                            <p class="fs-2 text-dark">
                                {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}
                            </p>
                        </div>

                        <!-- Fitur Permohonan Magang -->
                        @include('pages.home.fitur.permohonan')

                        <!-- Grafik Pendaftaran -->
                        @include('pages.home.fitur.pendaftaran')

                        <!-- Fitur Magang -->
                        @include('pages.home.fitur.magang')

                        <!-- Fitur Status Administrasi -->
                        @include('pages.home.fitur.statusAdministrasi')

                        <!-- Fitur Ringkasan -->
                        @include('pages.home.fitur.ringkasan')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
