<li class="nav-item dropdown">
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

    <!-- Titik merah kalau ada notifikasi -->
    @if($notifikasi->count() > 0)
      <span class="status-dot status-dot-animated bg-red"></span>
    @endif
  </a>

  <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow dropdown-menu-card">
    <div class="card">
      <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">Notifikasi</h3>
        <span class="badge bg-green-lt text-green">{{ $notifikasi->count() }} Baru</span>
      </div>

      <!-- Batasi tinggi dropdown -->
      <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
        <div class="list-group list-group-flush list-group-hoverable">

          @forelse ($notifikasi as $item)
            <a href="{{ $item->link }}" class="list-group-item list-group-item-action">
              <div class="row align-items-center">
                <div class="col-auto">
                  <span class="status-dot status-dot-animated bg-{{ $item->warna }}"></span>
                </div>
                <div class="col text-truncate">
                  <div class="fw-bold">{{ $item->pesan }}</div>
                  <div class="text-muted small mt-n1">
                    {{ \Carbon\Carbon::parse($item->waktu)->diffForHumans() }}
                  </div>
                </div>
              </div>
            </a>
          @empty
            <div class="list-group-item text-center text-muted">
              Tidak ada notifikasi
            </div>
          @endforelse

        </div>
      </div>
    </div>
  </div>
</li>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
