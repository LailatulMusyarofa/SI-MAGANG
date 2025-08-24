<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ringkasan Dashboard Magang</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
            line-height: 1.5;
        }
        .kop-surat {
            text-align: center;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
            position: relative;
            padding-left: 50px;
        }
        .kop-surat img {
            width: 60px;
            position: absolute;
            top: 10px;
            left: 40px;
        }
        .judul {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin: 20px 0;
        }
        .isi {
            text-align: justify;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table th, table td {
            border: 1px solid black;
            padding: 6px;
            text-align: center;
        }
        .footer {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT -->
    <div class="kop-surat">
        <img src="logoJatim.png" alt="Logo">
        <div>
            <div style="font-size:14pt; font-weight:bold;">PEMERINTAH PROVINSI JAWA TIMUR</div>
            <div style="font-size:14pt; font-weight:bold;">DINAS KOMUNIKASI DAN INFORMATIKA</div>
            <div style="font-size:11pt;">Jl. Ahmad Yani No.242-244, Gayungan, Surabaya, Jawa Timur 60235</div>
            <div style="font-size:11pt;">Telp. (031) 8294608, Fax. (031) 8294517, Email: kominfo@jatimprov.go.id</div>
        </div>
    </div>

    <!-- JUDUL -->
    <div class="judul">RINGKASAN DASHBOARD MAGANG</div>

    <!-- ISI -->
    <div class="isi">
        Memperhatikan hasil monitoring melalui Dashboard Sistem Informasi Magang (SIMA) hingga tanggal 
        <b>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}</b>, bersama ini disampaikan ringkasan capaian sebagai berikut:
        <br><br>

        Jumlah permohonan yang belum ditangani atau masih dalam status <i>pending</i> tercatat sebanyak <b>{{ $pending }}</b> mahasiswa. 
        Jumlah permohonan magang yang sudah ditangani tercatat sebanyak <b>{{ $pendaftar }}</b> mahasiswa, 
        Saat ini terdapat <b>{{$aktif}}</b> mahasiswa aktif magang, 
        dan sebanyak <b>{{$lulus}}</b> mahasiswa dinyatakan lulus bulan ini dengan persentase kelulusan <b>{{$persentase}}%</b>.
        <br><br>

        {{-- Distribusi Peserta Magang per Bidang menunjukkan bahwa:
        <ol>
            <li>Bidang Aplikasi Informatika menerima jumlah peserta terbanyak.</li>
            <li>Bidang Persandian dan Statistik mencatat jumlah peserta menengah.</li>
            <li>Bidang Informasi Publik dan Komunikasi relatif memiliki jumlah peserta lebih sedikit.</li>
        </ol> --}}

        Rekap Status Administrasi memperlihatkan bahwa sebagian besar peserta telah menyelesaikan dokumen wajib, meliputi: 
        <i>Surat Permohonan Magang, Proposal Magang, serta Laporan Magang</i>.
    </div>

    <!-- TABEL -->
    <table>
        <thead>
            <tr>
                <th>Status saat ini</th>
                <th>Masih Aktif</th>
                <th>Selesai</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Peserta</td>
                <td>{{$peserta}} Mahasiswa</td>
                <td>{{$pesertaSelesai}} Mahasiswa</td>
            </tr>   
            <tr>
                <td>Verifikasi Berkas</td>
                <td>{{$verifikasiBerkas}} Mahasiswa</td>
                <td>{{$verifikasiBerkasSelesai}} Mahasiswa</td>
            </tr>
            <tr>
                <td>Persetujuan Pimpinan</td>
                <td>{{$persetujuanPimpinan}} Mahasiswa</td>
                <td>{{$persetujuanPimpinanSelesai}} Mahasiswa</td>
            </tr>
            <tr>
                <td>Proses Magang</td>
                <td>{{$prosesMagang}} Mahasiswa</td>
                <td>{{$prosesMagangSelesai}} Mahasiswa</td>
            </tr>
            <tr>
                <td>Evaluasi</td>
                <td>{{$evaluasi}} Mahasiswa</td>
                <td>{{$evaluasiSelesai}} Mahasiswa</td>
            </tr>
            <tr>
                <td>Sertifikat</td>
                <td>{{$sertifikat}} Mahasiswa</td>
                <td>{{$sertifikatSelesai}} Mahasiswa</td>
            </tr>
        </tbody>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        Demikian ringkasan ini disampaikan sebagai bahan informasi dan evaluasi pelaksanaan program magang melalui SIMA.
    </div>

</body>
</html>
