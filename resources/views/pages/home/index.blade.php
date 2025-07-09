<x-app-layout pageTitle="Home">
    <x-page-header>
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <!-- Breadcrumb -->
                <x-breadcrumb pageTitle="Beranda"></x-breadcrumb>
                <div class="col-auto ms-auto d-flex align-items-center">
                 <ul class="navbar-nav">
                   <li class="nav-item dropdown"><!-- MODIFIKASI -->
                   <a href="#" class="nav-link" data-bs-toggle="dropdown" aria-label="Notifications">

                <!-- Icon Bell -->
                <svg class="icon icon-tabler icon-tabler-bell" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M5 17h14" />
                <path d="M17 17v-6a5 5 0 0 0 -10 0v6" />
                <path d="M9 21h6" />
                </svg>

                <!-- Titik merah animasi -->
                <span class="status-dot status-dot-animated bg-red"></span>
            </a>

  <!-- Dropdown isi notifikasi -->
  <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow dropdown-menu-card"><!-- MODIFIKASI -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Status Administrasi</h3>
        <div class="ms-auto">
          <span class="badge bg-green-lt text-green">1 Baru</span>
        </div>
      </div>
      <div class="card-body p-0">
        <div class="list-group list-group-flush list-group-hoverable">
          <!-- Notifikasi 1 -->
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="status-dot status-dot-animated bg-blue"></span>
              </div>
              <div class="col text-truncate">
                <a href="#" class="text-body d-block fw-bold">Permohonan Magang Baru dari Universitas Brawijaya</a>
                <div class="text-truncate mt-n1" style="color: #6c757d;">
                 3 Permohonan Magang baru sedang menunggu persetujuan
                </div>

              </div>
            </div>
          </div>
          <!-- Notifikasi 2 -->
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="status-dot status-dot-animated bg-gray"></span>
              </div>
              <div class="col text-truncate">
                <a href="#" class="text-body d-block">Dokumen Perlu Diverifikasi</a>
                <div class="text-truncate mt-n1" style="color: #6c757d;">Ahmad Rizki - dokumen CV perlu diverifikasi ulang</div>
              </div>
            </div>
          </div>
          <!-- Notifikasi 3 -->
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="status-dot status-dot-animated bg-green"></span>
              </div>
              <div class="col text-truncate">
                <a href="#" class="text-body d-block">Magang selesai</a>
                <div class="text-truncate mt-n1" style="color: #6c757d;">Sari Dewi telah menyelesaikan program magang</div>
              </div>
            </div>
          </div>
          <!-- Tambah notifikasi lain di sini jika dibutuhkan -->
        </div>
      </div>
    </div>
  </div>
</li>

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
        </div>
    </div>
</x-app-layout>
