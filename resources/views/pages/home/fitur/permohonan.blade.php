<div class="row row-deck" id="statistik-cards">
    <!-- Isi statik dulu, akan diubah JS -->
    <div class="col-md-3 mb-3">
        <div class="card h-100 shadow-sm border-0" style="border-radius: 50px;">
            <div class="card-body text-center" style="background-color:rgb(227, 255, 233); border-radius: 10px;">
                <p class="card-text text-muted">Permohonan Ditangani</p>
                <h1 id="jumlah-ditandatangani">90</h1>
                <p class="card-text text-muted">Sudah diproses admin</p>
                <p class="text-success" id="persentase-ditandatangani">↗ 12% dari bulan lalu</p>
            </div>
        </div>
    </div>

    <!-- Tambahkan 3 card lainnya: pending, aktif, lulus (mirip) -->

    <!-- Pending -->
    <div class="col-md-3 mb-3">
        <div class="card h-100 shadow-sm border-0" style="border-radius: 50px;">
            <div class="card-body text-center" style="background-color:rgb(255, 239, 188);">
                <p class="card-text text-muted">Permohonan Pending</p>
                <h1 id="jumlah-pending">8</h1>
                <p class="card-text text-muted">Menunggu tindak lanjut</p>
                <p class="text-danger" id="persentase-pending">↘ 5% dari bulan lalu</p>
            </div>
        </div>
    </div>

    <!-- Magang Aktif -->
    <div class="col-md-3 mb-3">
        <div class="card h-100 shadow-sm border-0" style="border-radius: 50px;">
            <div class="card-body text-center" style="background-color:rgb(192, 235, 253);">
                <p class="card-text text-muted">Total Magang Aktif</p>
                <h1 id="jumlah-aktif">9</h1>
                <p class="card-text text-muted">Sedang menjalani program</p>
                <p class="text-success" id="persentase-aktif">↗ 8% dari bulan lalu</p>
            </div>
        </div>
    </div>

    <!-- Lulus Bulan Ini-->
    <div class="col-md-3 mb-3">
        <div class="card h-100 shadow-sm border-0" style="border-radius: 50px;">
            <div class="card-body text-center" style="background-color:rgb(227, 255, 233);">
                <p class="card-text text-muted">Lulus Bulan Ini</p>
                <h1 id="jumlah-lulus">11</h1>
                <p class="card-text text-muted">Berhasil menyelesaikan</p>
                <p class="text-success" id="persentase-lulus">↗ 15% dari bulan lalu</p>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan script -->

<script>
document.addEventListener("DOMContentLoaded", function() { //elemen dengan ID jumlah-ditandatangani
    fetch('/dashboard/card-json') //kode ini membuat permintaan ke server
        .then(response => response.json()) //mengambil data JSON dari respons server
        .then(res => {
            const data = res.data; // data berisi informasi yang akan ditampilkan di kartu statistik

            // mengupdate elemen-elemen dengan ID yang sesuai
            document.getElementById('jumlah-ditandatangani').textContent = data.ditandatangani.jumlah; 
            document.getElementById('persentase-ditandatangani').textContent = data.ditandatangani.label; 

            document.getElementById('jumlah-pending').textContent = data.pending.jumlah; 
            document.getElementById('persentase-pending').textContent = data.pending.label; 

            document.getElementById('jumlah-aktif').textContent = data.aktif.jumlah;  
            document.getElementById('persentase-aktif').textContent = data.aktif.label; 

            document.getElementById('jumlah-lulus').textContent = data.lulus.jumlah; 
            document.getElementById('persentase-lulus').textContent = data.lulus.label; 
        })
        .catch(error => {    
            console.error('Gagal mengambil data:', error); 
        });
});
</script>


