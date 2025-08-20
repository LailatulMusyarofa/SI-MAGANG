{{-- resources/views/pages/home/fitur/pendaftaran.blade.php --}}
<!-- Header -->
<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-2">
    <h2 class="text-xl font-semibold text-gray-800 mb-0">Grafik Pendaftaran Magang</h2>
    <div class="flex items-center gap-2">
        <button id="tahun-kiri" class="bg-gray-100 px-2 py-1 rounded text-gray-600 text-sm">&lt;</button>
        <span id="tahun-text" class="text-gray-700 font-medium">2025</span>
        <button id="tahun-kanan" class="bg-gray-100 px-2 py-1 rounded text-gray-600 text-sm">&gt;</button>
    </div>
</div>

<!-- Card Chart -->
<div class="card mb-4">
    <div class="card-body">
        <div id="chart-demo-area" class="position-relative w-100" style="min-height:300px"></div>
    </div>
</div>

<!-- Script Grafik Area -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let tahun = 2025;
        const chartElement = document.getElementById('chart-demo-area');
        const tahunText = document.getElementById('tahun-text');
        let chart;

        function loadChartData(tahunDipilih) {
            fetch(`/grafik-pendaftaran/${tahunDipilih}`)
                .then(response => response.json())
                .then(data => {
                    tahunText.textContent = tahunDipilih;
                    tahun = tahunDipilih;

                    const options = {
                        chart: {
                            type: "area",
                            height: 300,
                            fontFamily: 'inherit',
                            toolbar: { show: false },
                            animations: { enabled: false },
                            parentHeightOffset: 0
                        },
                        dataLabels: { enabled: false },
                        fill: {
                            type: 'solid',
                            colors: [
                                'rgba(59,130,246,0.16)',
                                'rgba(96,255,79,0.16)'
                            ],
                        },
                        stroke: {
                            width: 2,
                            curve: "smooth",
                            lineCap: "round"
                        },
                        series: [
                            {
                                name: "Pendaftar",
                                data: data.pendaftar
                            },
                            {
                                name: "Diterima",
                                data: data.diterima
                            }
                        ],
                        tooltip: { theme: 'dark' },
                        grid: {
                            padding: { top: -20, right: 0, left: -4, bottom: -4 },
                            strokeDashArray: 4
                        },
                        xaxis: {
                            type: 'datetime',
                            categories: data.labels,
                            labels: { padding: 0 },
                            tooltip: { enabled: false },
                            axisBorder: { show: false }
                        },
                        yaxis: {
                            labels: { padding: 4 }
                        },
                        colors: ['#3b82f6', '#90ee90'],
                        legend: {
                            show: true,
                            position: 'bottom',
                            offsetY: 12,
                            markers: {
                                width: 10,
                                height: 10,
                                radius: 100
                            },
                            itemMargin: {
                                horizontal: 8,
                                vertical: 8
                            }
                        }
                    };

                    if (chart) {
                        chart.updateOptions(options);
                    } else {
                        chart = new ApexCharts(chartElement, options);
                        chart.render();
                    }
                });
        }

        // Tombol navigasi tahun
        document.getElementById('tahun-kiri').addEventListener('click', () => loadChartData(tahun - 1));
        document.getElementById('tahun-kanan').addEventListener('click', () => loadChartData(tahun + 1));

        // Load pertama kali
        loadChartData(tahun);
    });
</script>
@endpush
