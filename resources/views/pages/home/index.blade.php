                            <x-app-layout pageTitle="Home">
                                <x-page-header>
                                    <div class="container-xl">
                                        <div class="row g-2 align-items-center">
                                            <!-- Breadcrumb -->
                                            <x-breadcrumb pageTitle="Beranda"></x-breadcrumb>
                                            <!-- NOTIFIKASI -->
                                        <div class="col-auto ms-auto d-flex align-items-center">
                                            <ul class="navbar-nav flex-row align-items-center">
                                                @php
                                                    $user = Auth::user();
                                                @endphp

                                                @if ($user && $user->id === 1)
                                                    <!-- Print PDF Icon -->
                                                    <li class="nav-item me-3 mt-2">
                                                        <a href="{{ route('pdf.cetak') }}" target="_blank" class="nav-link" title="Cetak PDF">
                                                            <i class="fas fa-print" style="font-size: 1.2rem;"></i>
                                                        </a>
                                                    </li>
                                                    <!-- Notifikasi -->
                                                    <li class="nav-item">
                                                        @include('pages.home.fitur.notifikasi')
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                </x-page-header>

                                <div class="page-body">
                                    <div class="container-xl">
                                        <div class="row justify-content-center">
                                            <div class="col-12 col-md-12 col-lg-11">
                                                <div class="d-block">
                                                    <div class="col-12 bg-light p-7 rounded">
                                                        <h1 class="fw-bold fst-italic mb-4" style="font-size: 2.5rem;">Selamat Datang</h1>
                                                        <p class="fs-2 text-dark">
                                                        {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}
                                                        </p>
                                                    </div>
                                                        @if ($user && $user->id === 1)
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
                                                                <h1 data-countup="134"></h1>
                                                            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
                                                        @endif
                                                    </div>
                                                </x-app-layout>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

