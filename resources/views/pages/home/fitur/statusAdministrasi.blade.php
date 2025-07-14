<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<div class="card">
  <div class="card-body">
    <h3 class="card-title">Grafik Status Administrasi</h3>
    <div id="chart-demo-bar" class="position-relative"></div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    fetch('/statusAdministrasi')
      .then(response => response.json())
      .then(data => {
        const chart = new ApexCharts(document.getElementById('chart-demo-bar'), {
          chart: {
            type: "bar",
            fontFamily: 'inherit',
            height: 200,
            parentHeightOffset: 1,
            toolbar: { show: false },
            animations: { enabled: false },
            stacked: true,
          },
          plotOptions: {
            bar: {
              barHeight: '50%',
              horizontal: true,
            }
          },
          dataLabels: { enabled: false },
          series: data.series,
          tooltip: { theme: 'dark' },
          grid: {
            padding: { top: -20, right: 0, left: 8, bottom: -4 },
            strokeDashArray: 4,
          },
          xaxis: {
            labels: {
              padding: 0,
              formatter: val => val + "K",
            },
            tooltip: { enabled: false },
            axisBorder: { show: false },
            categories: data.categories
          },
          yaxis: { labels: { padding: 4 } },
          colors: ['#5858D6', '#3498db'],
          legend: {
            show: true,
            position: 'bottom',
            offsetY: 12,
            markers: { width: 10, height: 10, radius: 100 },
            itemMargin: { horizontal: 8, vertical: 8 },
          },
        });

        chart.render();
      })
      .catch(error => {
        console.error('Error loading chart data:', error);
        document.getElementById('chart-demo-bar').innerHTML = "<p class='text-danger'>Gagal memuat data chart.</p>";
      });
  });
</script>
