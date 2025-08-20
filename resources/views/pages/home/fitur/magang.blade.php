<div class="row">
    <!-- Kolom kiri: 2 grafik sejajar -->
    <div class="col-12 col-lg-9">
        <div class="row h-100">
            <!-- Grafik Line -->
            <div class="col-12 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="text-lg font-semibold mb-4">Magang Aktif per Bidang</h2>
                        <div id="chart-demo-line" class="w-100" style="min-height:300px"></div>
                    </div>
                </div>
            </div>
            <!-- Grafik Donut -->
            <div class="col-12 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h2 class="text-lg font-semibold mb-4">Magang Lulus per Bidang</h2>
                        <div id="chart-demo-pie" class="w-100" style="min-height:300px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom kanan: 2 kartu vertikal -->
    <div class="col-12 col-lg-3 d-flex flex-column">
        <!-- Kartu 1 -->
        <div class="mb-3">
            <div class="card h-100 shadow-sm" style="border-radius: 12px; background-color: #f1f5f9;">
                <div class="card-body text-center py-4">
                    <p class="mb-1 text-muted">Tingkat Penerimaan</p>
                    <p class="fw-bold" style="font-size: 1.8rem;" id="stat-penerimaan">...</p>
                    <p class="text-muted mb-0">Dari total pendaftar</p>
                </div>
            </div>
        </div>
        <!-- Kartu 2 -->
        <div>
            <div class="card h-100 shadow-sm" style="border-radius: 12px; background-color: #f1f5f9;">
                <div class="card-body text-center py-4">
                    <p class="mb-1 text-muted">Rata-rata Durasi</p>
                    <p class="fw-bold" style="font-size: 1.8rem;">
                        <span id="stat-durasi">...</span><span style="font-weight: normal;">/bulan</span>
                    </p>
                    <p class="text-muted mb-0">Lama program magang</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <!-- CDN ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch('/dashboard/magang/chart-data')
                .then(response => response.json())
                .then(data => {
                    // Update Statistik Kartu
                    document.getElementById('stat-penerimaan').innerText = data.tingkat_penerimaan + "%";
                    document.getElementById('stat-durasi').innerText = data.durasi_bulanan;

                    // === Chart Line: Magang Aktif per Bidang ===
                    let bulanLabels = data.aktif.map(item => item.bulan);
                    let progressMagang = data.aktif.map(item => parseInt(item.progress_magang));
                    let bidangMagang = data.aktif.map(item => parseInt(item.bidang_magang));
                    let totalMagang = data.aktif.map(item => parseInt(item.total_magang));

                    new ApexCharts(document.getElementById('chart-demo-line'), {
                        chart: {
                            type: "line",
                            height: 300,
                            fontFamily: 'inherit',
                            toolbar: {
                                show: false
                            },
                            animations: {
                                enabled: false
                            },
                            parentHeightOffset: 0
                        },
                        stroke: {
                            width: 2,
                            curve: "straight",
                            lineCap: "round"
                        },
                        series: [{
                                name: "Progress Magang",
                                data: progressMagang
                            },
                            {
                                name: "Bidang Magang",
                                data: bidangMagang
                            },
                            {
                                name: "Total Magang",
                                data: totalMagang
                            }
                        ],
                        labels: bulanLabels,
                        xaxis: {
                            labels: {
                                padding: 0
                            },
                            tooltip: {
                                enabled: false
                            },
                            axisBorder: {
                                show: false
                            }
                        },
                        yaxis: {
                            labels: {
                                padding: 4
                            }
                        },
                        tooltip: {
                            theme: 'dark'
                        },
                        grid: {
                            padding: {
                                top: -20,
                                right: 0,
                                bottom: -4,
                                left: -4
                            },
                            strokeDashArray: 4
                        },
                        colors: [
                            'rgba(234,179,8,1)', 'rgba(34,197,94,1)', 'rgba(59,130,246,1)'
                        ],
                        legend: {
                            show: true,
                            position: 'bottom',
                            offsetY: 12,
                            markers: {
                                width: 100,
                                height: 100,
                                radius: 1000
                            },
                            itemMargin: {
                                horizontal: 8,
                                vertical: 8
                            }
                        }
                    }).render();

                    // === Chart Donut: Magang Lulus per Bidang ===
                    let bidangTarget = [
                        "Bidang Aplikasi Informatika",
                        "Bidang Data dan Statistik",
                        "Bidang Komunikasi Publik",
                        "Bidang Persandian dan Keamanan",
                        "Sekretariat"
                    ];

                    let bidangMap = {
                        "Bidang Aplikasi Informatika": 0,
                        "Bidang Data dan Statistik": 0,
                        "Bidang Komunikasi Publik": 0,
                        "Bidang Persandian dan Keamanan": 0,
                        "Sekretariat": 0
                    };

                    // Isi jumlah berdasarkan hasil dari server
                    data.lulus.forEach(item => {
                        if (bidangMap.hasOwnProperty(item.nama_bidang)) {
                            bidangMap[item.nama_bidang] = parseInt(item.total);
                        }
                    });

                    let pieLabels = Object.keys(bidangMap);
                    let pieSeries = Object.values(bidangMap);

                    new ApexCharts(document.getElementById('chart-demo-pie'), {
                        chart: {
                            type: "donut",
                            height: 300,
                            fontFamily: 'inherit',
                            sparkline: {
                                enabled: true
                            },
                            animations: {
                                enabled: false
                            }
                        },
                        series: pieSeries,
                        labels: pieLabels.map((label, index) => `${label} (${pieSeries[index]})`),
                        colors: [
                            'rgba(59,130,246,1)', // Biru
                            'rgba(96,165,250,1)', // Biru muda
                            'rgba(147,197,253,1)', // Biru lebih muda
                            'rgba(209,213,219,1)', // Abu terang
                            'rgba(34,197,94,1)' // Hijau
                        ],
                        legend: {
                            show: true,
                            position: 'bottom',
                            offsetY: 12,
                            markers: {
                                width: 100,
                                height: 100,
                                radius: 100
                            },
                            itemMargin: {
                                horizontal: 8,
                                vertical: 8
                            }
                        },
                        tooltip: {
                            fillSeriesColor: false,
                            theme: 'dark'
                        }
                    }).render();

                });
        });
    </script>
@endpush
