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
                    <h1 class="card-title">Status Administrasi</h1>
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

  <div class="col-12 bg-light p-7 rounded">
    <h1 class="fw-bold fst-italic mb-4" style="font-size: 2.5rem;">Selamat Datang</h1>
    <p class="fs-2 text-dark">
      {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}
    </p>
  </div>





  <!-- card -->
  <div class="row row-deck">
    <div class="col-md-3">
      <div class="card shadow-sm border-0" style="border-radius: 50px;">
        <div class="card-body text-center" style="background-color:rgb(227, 255, 233); border-radius: 10px;">
          <p class="card-text text-muted">Permohonan Ditangani</p>
          <a href="#" class="btn btn-primary btn-sm"></a>
          <h1 id="countup-processed" data-countup="127" data-json='{"start": 0, "end": 127, "duration": 2}'>127</h1>
          <script>
            document.addEventListener("DOMContentLoaded", function() {
              const element = document.getElementById("countup-processed");
              const jsonData = JSON.parse(element.getAttribute("data-json"));
              let start = jsonData.start;
              const end = jsonData.end;
              const duration = jsonData.duration * 1000; // Convert to milliseconds
              const increment = (end - start) / (duration / 50); // Update every 50ms

              const counter = setInterval(() => {
                start += increment;
                if (start >= end) {
                  start = end;
                  clearInterval(counter);
                }
                element.textContent = Math.floor(start);
              }, 50);
            });
          </script>
          <p class="card-text text-muted" style="color: #28a745 !important;">Sudah diproses admin</p>
          <p class="text-success"><span class="text-success fw-normal">↗ 12% dari bulan lalu</span></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm border-0" style="border-radius: 50px;">
        <div class="card-body text-center" style="background-color:rgb(255, 239, 188);">
          <p class="card-text text-muted">Permohonan Pending</p>
          <a href="#" class="btn btn-primary btn-sm"></a>
          <h1 id="countup-pending" data-countup="123" data-json='{"start": 0, "end": 123, "duration": 2}'>123</h1>
          <script>
            document.addEventListener("DOMContentLoaded", function() {
              const element = document.getElementById("countup-pending");
              const jsonData = JSON.parse(element.getAttribute("data-json"));
              let start = jsonData.start;
              const end = jsonData.end;
              const duration = jsonData.duration * 1000; // Convert to milliseconds
              const increment = (end - start) / (duration / 50); // Update every 50ms

              const counter = setInterval(() => {
                start += increment;
                if (start >= end) {
                  start = end;
                  clearInterval(counter);
                }
                element.textContent = Math.floor(start);
              }, 50);
            });
          </script>
          <p class="card-text text-muted" style="color: #28a745 !important;">Menunggu tindak lanjut</p>
          <p class="text-danger" style="color: red;"><span class="text-danger fw-normal" style="color: red;">↘5% dari bulan lalu</span></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm border-0" style="border-radius: 50px;">
        <div class="card-body text-center" style="background-color:rgb(192, 235, 253);">
          <p class="card-text text-muted">Total Magang Aktif</p>
          <a href="#" class="btn btn-primary btn-sm"></a>
          <h1 id="countup-active" data-countup="151" data-json='{"start": 0, "end": 151, "duration": 2}'>151</h1>
          <script>
            document.addEventListener("DOMContentLoaded", function() {
              const element = document.getElementById("countup-active");
              const jsonData = JSON.parse(element.getAttribute("data-json"));
              let start = jsonData.start;
              const end = jsonData.end;
              const duration = jsonData.duration * 1000; // Convert to milliseconds
              const increment = (end - start) / (duration / 50); // Update every 50ms

              const counter = setInterval(() => {
                start += increment;
                if (start >= end) {
                  start = end;
                  clearInterval(counter);
                }
                element.textContent = Math.floor(start);
              }, 50);
            });
          </script>
          <p class="card-text text-muted" style="color: #28a745 !important;">Sedang menjalani program</p>
          <p class="text-success"><span class="text-success fw-normal">↗8% dari bulan lalu</span></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm border-0" style="border-radius: 50px;">
        <div class="card-body text-center" style="background-color:rgb(227, 255, 233);">
          <p class="card-text text-muted">Lulus Bulan Ini</p>
          <a href="#" class="btn btn-primary btn-sm"></a>
          <h1 id="countup-graduated" data-countup="134" data-json='{"start": 0, "end": 134, "duration": 2}'>134</h1>
          <script>
            document.addEventListener("DOMContentLoaded", function() {
              const element = document.getElementById("countup-graduated");
              const jsonData = JSON.parse(element.getAttribute("data-json"));
              let start = jsonData.start;
              const end = jsonData.end;
              const duration = jsonData.duration * 1000; // Convert to milliseconds
              const increment = (end - start) / (duration / 50); // Update every 50ms

              const counter = setInterval(() => {
                start += increment;
                if (start >= end) {
                  start = end;
                  clearInterval(counter);
                }
                element.textContent = Math.floor(start);
              }, 50);
            });
          </script>
          <p class="card-text text-muted" style="color: #28a745 !important;">Berhasil menyelesaikan</p>
          <p class="text-success"><span class="text-success fw-normal">↗ 15% dari bulan lalu</span></p>
        </div>
      </div>
    </div>
  </div>

  <!-- tahun pendaftaran magang -->
  <!-- Container -->
  <!-- Header -->
  <div class="flex items-center justify-between mb-4">
    <h2 class="text-xl font-semibold text-gray-800">Grafik Pendaftaran Magang</h2>
    <div class="flex items-center gap-2">
      <button class="bg-gray-100 px-2 py-1 rounded text-gray-600 text-sm">&lt;</button>
      <span class="text-gray-700 font-medium">2025</span>
      <button class="bg-gray-100 px-2 py-1 rounded text-gray-600 text-sm">&gt;</button>
    </div>
  </div>

  <!-- Card Chart -->
  <div class="card">
    <div class="card-body">
      <div id="chart-demo-area" class="position-relative "></div>
    </div>
  </div>

  <!-- Wrapper Grid -->
  <div class="grid grid-cols-12 gap-6">

    <!-- Kartu 1: Grafik Line -->
    <div class="col-span-12 md:col-span-6 lg:col-span-4">
      <div class="card h-[400px] w-full">
        <div class="card-body">
          <h2 class="text-lg font-semibold mb-4">Magang Aktif per Bidang</h2>
          <div id="chart-demo-line" class="w-full h-[300px]"></div>
        </div>
      </div>
    </div>

    <!-- Kartu 2: Donut Chart -->
    <div class="col-span-12 md:col-span-6 lg:col-span-4">
      <div class="card h-[400px] w-full">
        <div class="card-body">
          <h2 class="text-lg font-semibold mb-4">Magang Lulus per Bidang</h2>
          <div id="chart-demo-pie" class="w-full h-[300px]"></div>
        </div>
      </div>
    </div>

    <!-- Kartu 3: Teks atau Statistik -->
    <div class="col-span-12 md:col-span-6 lg:col-span-4">
      <div class="card h-[400px] w-full">
        <div class="card-body text-center flex flex-col justify-center">
          <h1 class="text-4xl font-bold text-blue-500 mb-2">3.2 bulan</h1>
          <p class="text-sm text-gray-600">Lama program magang</p>
        </div>
      </div>
    </div>
    <div class="col-span-12 md:col-span-6 lg:col-span-4">
      <div class="card h-[400px] w-full">
        <div class="card-body text-center flex flex-col justify-center">
          <h1 class="text-4xl font-bold text-blue-500 mb-2">3.2 bulan</h1>
          <p class="text-sm text-gray-600">Lama program magang</p>
        </div>
      </div>
    </div>

  </div>



  <!-- Script Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

  <!-- Chart Line -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      if (window.ApexCharts) {
        new ApexCharts(document.getElementById('chart-demo-line'), {
          chart: {
            type: "line",
            fontFamily: 'inherit',
            height: 300, // UBAH DI SINI agar sama dengan Donut
            parentHeightOffset: 0,
            toolbar: {
              show: false
            },
            animations: {
              enabled: false
            }
          },
          stroke: {
            width: 2,
            lineCap: "round",
            curve: "straight",
          },
          series: [{
              name: "Session Duration",
              data: [117, 92, 94, 98, 75, 110, 69, 80, 109, 113, 115, 95]
            },
            {
              name: "Page Views",
              data: [59, 80, 61, 66, 70, 84, 87, 64, 94, 56, 55, 67]
            },
            {
              name: "Total Visits",
              data: [53, 51, 52, 41, 46, 60, 45, 43, 30, 50, 58, 59]
            }
          ],
          labels: [
            '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24',
            '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28',
            '2020-06-29', '2020-06-30', '2020-07-01', '2020-07-02'
          ],
          xaxis: {
            type: 'datetime',
            labels: {
              padding: 0
            },
            tooltip: {
              enabled: false
            },
            axisBorder: {
              show: false
            },
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
              left: -4,
              bottom: -4
            },
            strokeDashArray: 4,
          },
          colors: [
            'rgba(234,179,8,1)', // yellow
            'rgba(34,197,94,1)', // green
            'rgba(59,130,246,1)' // blue
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
      }
    });
  </script>


  <!-- Chart Donut -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      if (window.ApexCharts) {
        new ApexCharts(document.getElementById('chart-demo-pie'), {
          chart: {
            type: "donut",
            fontFamily: 'inherit',
            height: 300, // disamakan dengan h-[300px] di div
            sparkline: {
              enabled: true
            },
            animations: {
              enabled: false
            }
          },
          series: [44, 55, 12, 2],
          labels: ["Teknik", "Manajemen", "Desain", "Lainnya"],
          colors: [
            'rgba(59,130,246,1)',
            'rgba(96,165,250,1)',
            'rgba(147,197,253,1)',
            'rgba(209,213,219,1)'
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
      }
    });
  </script>

  <!-- Include ApexCharts (pastikan ini di-layout utama jika pakai Blade) -->
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      if (window.ApexCharts) {
        new ApexCharts(document.getElementById('chart-demo-area'), {
          chart: {
            type: "area",
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
          dataLabels: {
            enabled: false
          },
          fill: {
            type: 'solid',
            colors: [
              'rgba(59,130,246,0.16)', // biru transparan
              'rgba(96, 255, 79, 0.16)' // ungu transparan
            ],
          },
          stroke: {
            width: 2,
            curve: "smooth",
            lineCap: "round"
          },
          series: [{
              name: "Pendaftar",
              data: [56, 40, 39, 47, 34, 48, 44]
            },
            {
              name: "Diterima",
              data: [45, 43, 30, 23, 38, 39, 54]
            }
          ],
          tooltip: {
            theme: 'dark'
          },
          grid: {
            padding: {
              top: -20,
              right: 0,
              left: -4,
              bottom: -4
            },
            strokeDashArray: 4
          },
          xaxis: {
            type: 'datetime',
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
          labels: [
            '2020-06-21', '2020-06-22', '2020-06-23',
            '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27'
          ],
          colors: [
            'rgba(59,130,246,1)', // biru
            'rgb(149, 255, 137)' // ungu
          ],
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
        }).render();
      }
    });
  </script>



  </div>
  </div>
  </div>

</x-app-layout>