<aside class="navbar navbar-vertical navbar-expand-lg black" data-bs-theme="light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Logo desktop -->
        <div class="navbar navbar-expand-md d-none d-lg-flex d-print-none"
            style="background-color: #605ca8;color:black; display: flex; align-items: center; justify-content: center;">
            <span class="navbar-brand-text text-white me-2" id="brand-text" style="margin-right: 8px;">
                <span style="font-weight: bold; font-size: 1.5em;">SI</span>
                <span style="font-weight: normal; font-size: 1.5em;" id="magang-text">MAGANG</span>
                <!-- <span class="mdi mdi-reorder-horizontal"></span> -->
            </span>
        </div>

        <!-- Logo mobile -->
        <div class="navbar navbar-expand-md d-flex d-lg-none d-print-none"
            style="background-color: transparent; color: #605ca8; display: flex; align-items: center; justify-content: center;">
            <span class="navbar-brand-text me-2" style="margin-right: 8px;">
                <span style="font-weight: bold; font-size: 1.2em; color: #605ca8;">SI</span>
                <span style="font-weight: normal; font-size: 1.2em; color: #605ca8;">MAGANG</span>
            </span>
        </div>
        <div class="navbar-nav flex-row d-lg-none">
            <!-- Additional mobile buttons or links can go here -->
        </div><br>

        @auth
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                    aria-label="Open user menu">
                    @php
                        $avatarImg =
                            Auth::user()->role_id == 1
                                ? asset('static/avatars/Jatim.png') // Super Admin
                                : asset('static/avatars/TWH.png'); // Instansi (Role ID 2)
                    @endphp
                    <span class="avatar avatar-sm"
                        style="background-image: url('{{ $avatarImg }}'); margin-left: 15px;"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ Auth::user()->fullname }}</div>
                        <div class="small text-secondary">{{ Auth::user()->role->name }}</div>
                        <div class="small text-success d-flex align-items-center" style="margin-top: 0px;">
                            <span class="badge bg-success rounded-circle"
                                style="width: 8px; height: 8px; margin-right: 5px;"></span>
                            Online
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="{{ route('user.setting') }}" class="dropdown-item">Personalisasi Akun</a>
                    <button class="dropdown-item" onclick="logoutNow()">Keluar</button>
                </div>
            </div>
        @endauth




        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                @if (Auth::user()->role_id == 1)
                    <!-- Menu untuk Super Admin -->
                    <li><a class="nav-link" href="{{ route('home') }}"><span class="mdi mdi-home"
                                style="font-size: 24px; margin-right: 4px;"></span> Beranda</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('master_sklh') }}">
                            <span class="mdi mdi-bank" style="font-size: 24px; margin-right: 4px;"></span>
                            Lembaga Pendidikan
                            <span class="pull-right-container">
                                @if (\App\Models\MasterSklh::join('users', 'users.id', '=', 'master_sklh.id_user')->where('akun_diverifikasi', 'belum')->count() > 0)
                                    <small class="label pull-right bg-red"
                                        style="font-size: 12px; margin-left: 4px; padding: 4px 5px;">
                                        {{ \App\Models\MasterSklh::join('users', 'users.id', '=', 'master_sklh.id_user')->where('akun_diverifikasi', 'belum')->count() }}
                                    </small>
                                @endif
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link d-flex justify-content-between align-items-center"
                            href="{{ route('proposal_masuk') }}">
                            <span class="mdi mdi-inbox" style="font-size: 24px; margin-right: 4px;"></span>
                            Permohonan Magang
                            <span class="pull-right-container d-flex align-items-center">
                                <!-- Menampilkan jumlah permohonan magang yang terkirim dan belum dibaca -->
                                @if (\App\Models\PermintaanMgng::where('status_surat_permintaan', 'terkirim')->where('status_baca_surat_permintaan', 'belum')->count() > 0)
                                    <small class="label pull-right bg-green"
                                        style="font-size: 12px; margin-left: 4px; padding: 4px 5px;">
                                        {{ \App\Models\PermintaanMgng::where('status_surat_permintaan', 'terkirim')->where('status_baca_surat_permintaan', 'belum')->count() }}
                                    </small>
                                @endif

                                @if (
                                    \App\Models\PermintaanMgng::where('status_surat_permintaan', 'terkirim')->whereDoesntHave('balasan2', function ($query) {
                                            $query->whereNotNull('nomor_surat_balasan');
                                        })->count() > 0)
                                    <small class="label pull-right bg-red"
                                        style="font-size: 12px; margin-left: 4px; padding: 4px 5px;">
                                        {{ \App\Models\PermintaanMgng::where('status_surat_permintaan', 'terkirim')->whereDoesntHave('balasan2', function ($query) {
                                                $query->whereNotNull('nomor_surat_balasan');
                                            })->count() }}
                                    </small>
                                @endif
                            </span>
                        </a>
                    </li>


                    <li><a class="nav-link" href="{{ route('proposal_keluar') }}"><span class="mdi mdi-send"
                                style="font-size: 24px; margin-right: 4px;"></span>Balasan Magang</a></li>
                    <li><a class="nav-link" href="{{ route('nota_dinas.daftar') }}"><span
                                class="mdi mdi-note-text-outline"
                                style="font-size: 24px; margin-right: 4px;"></span>Nota Dinas Magang</a></li>
                    <li><a class="nav-link" href="{{ route('proposal_final.daftar') }}"><span class="mdi mdi-decagram"
                                style="font-size: 24px; margin-right: 4px;"></span>Laporan & Sertifikat</a></li>
                    <li><a class="nav-link" href="{{ route('master_petugas') }}"><span class="mdi mdi-account-group"
                                style="font-size: 24px; margin-right: 4px;"></span>Kelola Penilai</a></li>
                    <li>
                        <a class="nav-link d-flex align-items-center" href="{{ route('master_administrasi') }}">
                            <i class="mdi mdi-clipboard-list-outline me-2" style="font-size: 20px;"></i>
                            <span>Daftar Administrasi</span>
                        </a>

                    </li>

                    <li><a class="nav-link" href="{{ route('master_keluar') }}">
                            <button type="button" class="btn btn-outline-danger" onclick="logoutNow()">
                                <span class="mdi mdi-logout" style="font-size: 24px; margin-right: 4px;">
                                </span>Keluar</button></a>
                    </li>
                @elseif(Auth::user()->role_id == 2)
                    <!-- Menu untuk User (Instansi) -->
                    <!-- <li><a class="nav-link" href="{{ route('home') }}"><span class="mdi mdi-home" style="font-size: 24px; margin-right: 4px;"></span> Beranda</a></li> -->

                    @if (session('isDataComplete') == false)
                        <li><a class="nav-link" href="{{ route('lengkapi_data') }}"><span class="mdi mdi-plus"
                                    style="font-size: 24px; margin-right: 4px;"></span> Lengkapi Data</a></li>
                    @else
                        <li class="nav-item">
                            <h5 class="text-muted text-uppercase"
                                style="font-size: 14px; margin-top: 20px; margin-left: 15px;">Data Lembaga Pendidikan
                            </h5>
                        </li>
                        <li><a class="nav-link" href="{{ route('detail_data') }}"><span class="mdi mdi-eye"
                                    style="font-size: 24px; margin-right: 4px;"></span> Detail Data</a></li>
                        <li><a class="nav-link" href="{{ route('edit_data') }}"><span class="mdi mdi-pencil"
                                    style="font-size: 24px; margin-right: 4px;"></span> Edit Data</a></li>

                        @if (Auth::user()->akun_diverifikasi === 'sudah')
                            <li class="nav-item">
                                <h5 class="text-muted text-uppercase"
                                    style="font-size: 14px; margin-top: 20px; margin-left: 15px;">Data Permohonan</h5>
                            </li>
                            <li><a class="nav-link" href="{{ route('buat_permohonan') }}"><span class="mdi mdi-plus"
                                        style="font-size: 24px; margin-right: 4px;"></span> Buat Permohonan</a></li>
                            <li><a class="nav-link" href="{{ route('user.daftar_permohonan') }}"><span
                                        class="mdi mdi-email" style="font-size: 24px; margin-right: 4px;"></span>
                                    Daftar Permohonan</a></li>
                            <li><a class="nav-link" href="{{ route('user.daftar_permohonanmasuk') }}"><span
                                        class="mdi mdi-inbox" style="font-size: 24px; margin-right: 4px;"></span>
                                    Daftar Diterima
                                    <span class="pull-right-container">
                                        @if (\App\Models\MasterMgng::join('master_sklh', 'master_sklh.id', '=', 'master_mgng.master_sklh_id')->join('users', 'users.id', '=', 'master_sklh.id_user')->join('balasan_mgng', 'balasan_mgng.master_mgng_id', '=', 'master_mgng.id')->where('users.id', Auth::user()->id)->where('balasan_mgng.status_surat_balasan', 'terkirim')->where('balasan_mgng.status_baca_surat_balasan', 'belum')->count() > 0)
                                            <small class="label pull-right bg-green">
                                                {{ \App\Models\MasterMgng::join('master_sklh', 'master_sklh.id', '=', 'master_mgng.master_sklh_id')->join('users', 'users.id', '=', 'master_sklh.id_user')->join('balasan_mgng', 'balasan_mgng.master_mgng_id', '=', 'master_mgng.id')->where('users.id', Auth::user()->id)->where('balasan_mgng.status_surat_balasan', 'terkirim')->where('balasan_mgng.status_baca_surat_balasan', 'belum')->count() }}
                                            </small>
                                        @endif

                                        @if (\App\Models\MasterMgng::join('master_sklh', 'master_sklh.id', '=', 'master_mgng.master_sklh_id')->join('users', 'users.id', '=', 'master_sklh.id_user')->join('balasan_mgng', 'balasan_mgng.master_mgng_id', '=', 'master_mgng.id')->where('users.id', Auth::user()->id)->where('balasan_mgng.status_surat_balasan', 'terkirim')->where('balasan_mgng.status_baca_surat_balasan', 'belumbacaupdate')->count() > 0)
                                            <small class="label pull-right bg-red">
                                                {{ \App\Models\MasterMgng::join('master_sklh', 'master_sklh.id', '=', 'master_mgng.master_sklh_id')->join('users', 'users.id', '=', 'master_sklh.id_user')->join('balasan_mgng', 'balasan_mgng.master_mgng_id', '=', 'master_mgng.id')->where('users.id', Auth::user()->id)->where('balasan_mgng.status_surat_balasan', 'terkirim')->where('balasan_mgng.status_baca_surat_balasan', 'belumbacaupdate')->count() }}
                                            </small>
                                        @endif
                                    </span>
                                </a></li>
                            <li><a class="nav-link" href="{{ route('user.daftar_laporanmagang') }}"><span
                                        class="mdi mdi-file" style="font-size: 24px; margin-right: 4px;"></span>
                                    Daftar Laporan</a></li>
                        @endif
                    @endif
                @endif
            </ul>
        </div>
    </div>
</aside>
