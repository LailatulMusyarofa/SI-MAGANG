@php
 
  $notifikasi = $notifikasi ?? collect();
  $jumlah = $notifikasi->count();
@endphp

<li class="nav-item dropdown">
  <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-label="Notifications">
   
    <svg class="icon icon-tabler icon-tabler-bell" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
      viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
      stroke-linecap="round" stroke-linejoin="round">
      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
      <path d="M5 17h14" />
      <path d="M17 17v-6a5 5 0 0 0 -10 0v6" />
      <path d="M9 21h6" />
    </svg>

  
    <span class="status-dot status-dot-animated bg-red" id="notifDot" style="{{ $jumlah > 0 ? '' : 'display:none' }}"></span>
  </a>

  <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow dropdown-menu-card">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title m-0">Notifikasi</h3>
        <div class="d-flex align-items-center gap-2">
          <span class="badge bg-green-lt text-green" id="notifCount">{{ $jumlah }} Baru</span>
          @if($jumlah > 0)
            <button class="btn btn-link btn-sm text-decoration-none" id="btnMarkAll" type="button">
              Tandai semua telah dibaca
            </button>
          @endif
        </div>
      </div>

      
      <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
        <div class="list-group list-group-flush list-group-hoverable" id="notifList">
          @forelse ($notifikasi as $item)
            @php
              
              $kLink = $item->link ?? '#';
              $kTime = isset($item->waktu) ? (string)$item->waktu : '';
              $dataKey = sha1($kLink . '|' . $kTime); 
            @endphp

            <a href="{{ $item->link ?? '#' }}"
               class="list-group-item list-group-item-action js-notif-item notif-collapse"
               data-key="{{ $dataKey }}">
              <div class="row align-items-center">
                <div class="col-auto">
                  <span class="status-dot status-dot-animated bg-{{ $item->warna ?? 'red' }}"></span>
                </div>
                <div class="col text-truncate">
                  <div class="fw-bold">{{ $item->pesan ?? 'Notifikasi' }}</div>
                  <div class="text-muted small mt-n1">
                    {{ \Carbon\Carbon::parse($item->waktu ?? now())->diffForHumans() }}
                  </div>
                </div>
              </div>
            </a>
          @empty
            <div class="list-group-item text-center text-muted" id="notifEmpty">
              Tidak ada notifikasi
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</li>

<style>
  .notif-collapse {
    overflow: hidden;
    transition:
      opacity .25s ease,
      max-height .25s ease,
      padding-top .25s ease,
      padding-bottom .25s ease,
      margin-top .25s ease,
      margin-bottom .25s ease;
    opacity: 1;
    max-height: 120px;
  }
  .notif-collapsing {
    opacity: 0;
    max-height: 0;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    margin-top: 0 !important;
    margin-bottom: 0 !important;
  }
</style>

<script>
(function() {
  const LS_KEY = 'notif:dismissed:v1'; 
  const list   = document.getElementById('notifList');
  const badge  = document.getElementById('notifCount');
  const dot    = document.getElementById('notifDot');
  const btnAll = document.getElementById('btnMarkAll');

  function loadSet() {
    try {
      const raw = localStorage.getItem(LS_KEY);
      const arr = raw ? JSON.parse(raw) : [];
      return new Set(arr);
    } catch { return new Set(); }
  }
  function saveSet(set) {
    localStorage.setItem(LS_KEY, JSON.stringify(Array.from(set)));
  }

  function visibleCount() {
    return list?.querySelectorAll('.js-notif-item')?.length || 0;
  }
  function updateBadgeAndDot() {
    const n = visibleCount();
    if (badge) badge.textContent = n + ' Baru';
    if (dot) dot.style.display = n > 0 ? '' : 'none';
    if (n === 0 && list && !document.getElementById('notifEmpty')) {
      const empty = document.createElement('div');
      empty.className = 'list-group-item text-center text-muted';
      empty.id = 'notifEmpty';
      empty.textContent = 'Tidak ada notifikasi';
      list.appendChild(empty);
      btnAll?.remove();
    }
  }

  
  const dismissed = loadSet();
  list?.querySelectorAll('.js-notif-item')?.forEach(a => {
    const key = a.getAttribute('data-key');
    if (key && dismissed.has(key)) {
      a.remove(); 
    }
  });
  updateBadgeAndDot();

  
  list?.addEventListener('click', function(e) {
    const a = e.target.closest('.js-notif-item');
    if (!a) return;

    const key  = a.getAttribute('data-key');
    const href = a.getAttribute('href') || '#';
    const newTab = e.ctrlKey || e.metaKey || e.button === 1;

    e.preventDefault();

    
    a.classList.add('notif-collapsing');

  
    if (key) { dismissed.add(key); saveSet(dismissed); }

   
    setTimeout(() => {
      a.remove();
      updateBadgeAndDot();
      if (href && href !== '#') {
        if (newTab) window.open(href, '_blank');
        else window.location.assign(href);
      }
    }, 220);
  });

  btnAll?.addEventListener('click', () => {
    list?.querySelectorAll('.js-notif-item')?.forEach(a => {
      const key = a.getAttribute('data-key');
      a.classList.add('notif-collapsing');
      if (key) dismissed.add(key);
      setTimeout(() => { a.remove(); updateBadgeAndDot(); }, 220);
    });
    saveSet(dismissed);
  });
})();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
