<li class="nav-item dropdown"><!-- MODIFIKASI -->
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-label="Notifications">

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
          <!-- Notifikasi pake json -->
          @foreach ($notifikasi ?? [] as $item)
          <div class="list-group-item">
            <div class="row align-items-center">
              <div class="col-auto">
                <span class="status-dot status-dot-animated bg-{{ $item['status'] }}"></span>
              </div>
              <div class="col text-truncate">
                <a href="#" class="text-body d-block fw-bold">{{ $item['title'] }}</a>
                <div class="text-truncate mt-n1" style="color: #6c757d;">
                 {{ $item['message'] }}
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</li>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>