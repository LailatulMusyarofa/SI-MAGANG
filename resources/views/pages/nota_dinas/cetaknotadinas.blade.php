<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nota Dinas - {{ $notaDinas->nomor_nota_dinas }}</title>
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
            font-size: 11pt;
        }
        th {
            background-color: #eee;
            text-align: center;
        }
        .center {
            text-align: center;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .header img {
            float: left;
            width: 60px;
        }
        p {
            text-indent: 2em;
            text-align: justify;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .ttd-wrapper {
            page-break-inside: avoid;
            break-inside: avoid;
            margin-top: 40px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <img src="{{ public_path('dist/img/jatim.png') }}" alt="logo">
        <p><strong>PEMERINTAH PROVINSI JAWA TIMUR</strong></p>
        <p><strong>DINAS KOMUNIKASI DAN INFORMATIKA</strong></p>
        <p>Jl. A. Yani No. 242-244 Surabaya Telp. (031) 8294608</p>
        <p>Website: kominfo.jatimprov.go.id | Email: kominfo@jatimprov.go.id</p>
        <p><strong><u>SURABAYA 60235</u></strong></p>
    </div>

    <table>
        <tr>
            <td style="width: 60%"></td>
            <td style="text-align: right;">
                Surabaya, {{ \Carbon\Carbon::parse($notaDinas->tanggal_nota_dinas)->translatedFormat('d F Y') }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-left: 422px;">
                Kepada Yth.<br>
                Sdr. Kepala {{ $notaDinas->masterBdng->nama_bidang ?? '-' }}
            </td>
        </tr>
        <tr>
            <td>Nomor : 400.14.5.4/{{ $notaDinas->nomor_nota_dinas }}/114.1/{{ \Carbon\Carbon::parse($notaDinas->tanggal_nota_dinas)->format('Y') }}</td>
        </tr>
        <tr>
            <td>Sifat : {{ ucfirst($notaDinas->sifat_nota_dinas) }}</td>
        </tr>
        <tr>
            <td>Lampiran : {{ $notaDinas->lampiran_nota_dinas == 'tidakada' ? '-' : '1 (Satu) berkas' }}</td>
        </tr>
        <tr>
            <td>Perihal : Permohonan Magang</td>
        </tr>
    </table>

    <p>
        Menindaklanjuti permohonan magang dengan Nomor Surat Permintaan <strong>{{ $permintaan->nomor_surat_permintaan }}</strong> tanggal <strong>{{ \Carbon\Carbon::parse($permintaan->tanggal_surat_permintaan)->translatedFormat('d F Y') }}</strong>, bersama ini disampaikan daftar peserta magang:
    </p>

    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peserta</th>
                <th>@if($permintaan->jenis_sklh != 'ptg') NIS @else NIM @endif</th>
                <th>Program Studi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peserta as $index => $p)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td>{{ $p->nama_peserta }}</td>
                    <td class="center">{{ $p->nis_peserta }}</td>
                    <td class="center">{{ $p->program_studi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p>
        Bersama ini disampaikan kepada Saudara untuk bersedia menerima Permohonan Magang dimaksud mulai tanggal <strong>{{ \Carbon\Carbon::parse($permintaan->balasan->tanggal_awal_magang)->translatedFormat('d F Y') }}</strong> s.d. <strong>{{ \Carbon\Carbon::parse($permintaan->balasan->tanggal_akhir_magang)->translatedFormat('d F Y') }}</strong> di {{ $notaDinas->masterBdng->nama_bidang ?? '-' }}.
        @if($permintaan->metode_magang == 'online') Secara daring/online.@endif
    </p>

    <p>Demikian atas perhatian dan kerjasamanya disampaikan terima kasih.</p>

    <div class="ttd-wrapper">
        <table width="100%">
            <tr>
                <td style="width: 60%"></td>
                <td>
                    a.n. Kepala Dinas Komunikasi dan Informatika<br>
                    Provinsi Jawa Timur<br>
                    Sekretaris
                </td>
            </tr>
            <tr><td></td><td style="height: 40px;"></td></tr>
            <tr>
                <td></td>
                <td>
                    @if($pejabat)
                        <strong><u>{{ $pejabat->nama_pejabat }}</u></strong><br>{{ $pejabat->pangkat_pejabat }}<br>NIP. {{ $pejabat->nip_pejabat }}
                    @else
                        <span class="text-muted">Data pejabat belum tersedia</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
