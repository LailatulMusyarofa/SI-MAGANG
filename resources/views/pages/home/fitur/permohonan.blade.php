<div class="container-fluid">
    <div class="row g-3">
        <!-- Permohonan Ditangani -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 text-center" style="border-radius: 20px; background-color: #eaffea;">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h6 class="text-muted mb-2">Permohonan Ditangani</h6>
                    <h3 class="fw-bold mb-2">{{ $permohonanDitangani ?? 12}}</h3>
                    <p class="text-muted small mb-1">Sudah diproses admin</p>
                </div>
            </div>
        </div>

        <!-- Permohonan Pending -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 text-center" style="border-radius: 20px; background-color: #fff6d9;">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h6 class="text-muted mb-2">Permohonan Pending</h6>
                    <h3 class="fw-bold mb-2">{{ $permohonanPending ?? 0}}</h3>
                    <p class="text-muted small mb-1">Menunggu tindak lanjut</p>
                </div>
            </div>
        </div>

        <!-- Total Magang Aktif -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 text-center" style="border-radius: 20px; background-color: #e6f5ff;">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h6 class="text-muted mb-2">Total Magang Aktif</h6>
                    <h3 class="fw-bold mb-2">{{ $magangAktif ?? 11}}</h3>
                    <p class="text-muted small mb-1">Sedang menjalani program</p>
                </div>
            </div>
        </div>

        <!-- Lulus Bulan Ini -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card shadow-sm border-0 h-100 text-center" style="border-radius: 20px; background-color: #eaffea;">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h6 class="text-muted mb-2">Lulus Bulan Ini</h6>
                    <h3 class="fw-bold mb-2">{{ $lulusBulanIni ?? 8}}</h3>
                    <p class="text-muted small mb-1">Berhasil menyelesaikan</p>
                </div>
            </div>
        </div>
    </div>
</div>