<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Permohonan Magang - {{ $rc->nomor_surat_permintaan }}</title>
    <style>
        @page {
            size: A4;
            margin: 1.5cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            margin: 0;
            padding: 0;
            line-height: 1.4;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: avoid;
        }

        th, td {
            padding: 5px;
            vertical-align: top;
        }

        .center {
            text-align: center;
        }

        .header img {
            float: left;
            width: 60px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header p {
            margin: 0;
            line-height: 1.2;
        }

        .content-table, .content-table th, .content-table td {
            border: 1px solid #000;
        }

        .content-table th {
            background-color: #eee;
            text-align: center;
        }

        .section {
            margin-top: 12px;
        }

        .text-justify {
            text-align: justify;
            text-indent: 2em;
        }

        .ttd-wrapper {
            page-break-inside: avoid;
            break-inside: avoid;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <img src="dist/img/jatim.png" alt="logo">
        <p><strong>PEMERINTAH PROVINSI JAWA TIMUR</strong></p>
        <p><strong>DINAS KOMUNIKASI DAN INFORMATIKA</strong></p>
        <p>Jl. A. Yani No. 242-244 Surabaya Telp. (031) 8294608</p>
        <p>Website: kominfo.jatimprov.go.id | Email: kominfo@jatimprov.go.id</p>
        <p><strong><u>SURABAYA 60235</u></strong></p>
    </div>

    <!-- Informasi Surat -->
    <table>
        <tr>
            <td style="width: 60%"></td>
            <td style="text-align: right;">
                Surabaya, {{ \Carbon\Carbon::parse($balasan->tanggal_surat_balasan)->locale('id')->translatedFormat('d F Y') }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-left: 422px;">
                Kepada Yth. Sdr. {{ $rc->ditandatangani_oleh }} {{ $rc->masterMgng->masterSklh->user->fullname }}<br>
                di<br>
                <b><u>TEMPAT</u></b>
            </td>
        </tr>
        <tr>
            <td style="width: 25%;">Nomor : 400.14.5.4/{{ $balasan->nomor_surat_balasan }}/114.1/{{ \Carbon\Carbon::parse($rc->tanggal_surat_balasan)->format('Y') }}</td>
        </tr>
        <tr>
            <td>Sifat : {{ $balasan->sifat_surat_balasan }}</td>
        </tr>
        <tr>
            <td>Lampiran : {{ $balasan->lampiran_surat_balasan == 'selembar' ? '1 (Satu Lembar)' : $balasan->lampiran_surat_balasan ?? '-' }}</td>
        </tr>
        <tr>
            <td>Perihal : Permohonan Magang</td>
        </tr>
    </table>

    <!-- Isi Surat -->
    <p class="section text-justify">
        Sehubungan dengan surat Saudara tanggal {{ \Carbon\Carbon::parse($rc->tanggal_surat_permintaan)->format('d F Y') }} nomor {{ $rc->nomor_surat_permintaan }}, perihal {{ $rc->perihal_surat_permintaan }}, bersama ini disampaikan bahwa Dinas Komunikasi dan Informatika Provinsi Jawa Timur menerima Permohonan Magang 
        @if($rc->jenis_sklh != 'ptg') Siswa/Siswi @else Mahasiswa/Mahasiswi @endif {{ $rc->name }}
        @if($rc->metode_magang == 'online') secara Daring/<i>Online</i> @endif atas nama:
    </p>

    <!-- Tabel Peserta -->
    <table class="content-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peserta</th>
                <th>NIS/NIM</th>
                <th>Program Studi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rd as $index => $peserta)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td>{{ $peserta->nama_peserta }}</td>
                    <td class="center">{{ $peserta->nis_peserta }}</td>
                    <td class="center">{{ $peserta->program_studi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Ketentuan -->
    <p class="section">Pelaksanaan magang diatur dalam ketentuan sebagai berikut :</p>
    <table>
        <tr><td>1.</td><td>Jadwal Magang: {{ \Carbon\Carbon::parse($balasan->tanggal_awal_magang)->locale('id')->translatedFormat('d F Y') }} s.d. {{ \Carbon\Carbon::parse($balasan->tanggal_akhir_magang)->locale('id')->translatedFormat('d F Y') }}</td></tr>
        <tr><td>2.</td><td>Jam kerja: 08.00 - 14.00 WIB</td></tr>
        <tr><td>3.</td><td>{{ $rc->masterMgng->masterSklh->user->fullname }} wajib mengunggah laporan magang melalui sima.jatimprov.go.id</td></tr>
    </table>

    <p>Demikian atas perhatian dan kerjasamanya disampaikan terima kasih.</p>

    <!-- Tanda Tangan -->
    <div class="ttd-wrapper">
        <table class="footer-table section">
            <tr>
                <td style="width: 60%"></td>
                <td>
                    a.n. Kepala Dinas Komunikasi dan Informatika<br>
                    Provinsi Jawa Timur<br>
                    Sekretaris
                </td>
            </tr>
            <tr><td></td><td style="height: 40px;"></td></tr>
            <tr><td></td><td><strong><u>{{ $pejabat->nama_pejabat }}</u></strong><br>{{ $pejabat->pangkat_pejabat }}</td></tr>
            <tr><td></td><td>NIP. {{ $pejabat->nip_pejabat }}</td></tr>
        </table>
    </div>

</body>
</html>