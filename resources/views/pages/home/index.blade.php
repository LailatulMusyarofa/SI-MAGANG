<x-app-layout pageTitle="Home">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <!-- Breadcrumb -->
                <x-breadcrumb pageTitle="Beranda"></x-breadcrumb>
                <!-- NOTIFIKASI -->
                <div class="col-auto ms-auto d-flex align-items-center">
                    <ul class="navbar-nav">
                        @include('pages.home.fitur.notifikasi')
                    </ul>
                </div>
            </div>
        </div>
    </x-page-header>

    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="d-block">
                        <h3 class="mb-2">Selamat Datang!</h3>
                        <h1 class="mb-1 fw-bold">Tanggal saat ini</h1>
                        <h1 class="mt-0">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</h1>
                    </div>
                </div>
            </div>
            <!-- FITUR STATUS ADMINISTRASI -->
            @include('pages.home.fitur.statusAdministrasi')

            <!-- FITUR RINGKASAN  -->
             @include('pages.home.fitur.ringkasan')
        </div>
    </div>
</x-app-layout>
