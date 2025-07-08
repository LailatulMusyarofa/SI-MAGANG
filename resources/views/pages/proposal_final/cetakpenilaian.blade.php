<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Penilaian - {{ $rc->nama_peserta }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 10px 20px;
            line-height: 1.2;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 5px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 4px 6px;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: left;
        }
        .no-border {
            border: none;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
            font-size: 13px;
            line-height: 1.1;
        }
        .header img {
            width: 70px;
            height: auto;
            margin-bottom: 3px;
        }
        h2 {
            margin: 10px 0 8px;
            font-size: 16px;
        }
        /* Reduce vertical spacing around paragraphs inside notes */
        p {
            margin: 3px 0;
        }
        /* Container catatan */
        .catatan {
            border: 1px solid black;
            padding: 8px;
            max-width: 1000px;
            margin: 8px 0;
            font-size: 11px;
        }
        /* Signature table adjustments */
        table.signature {
            border: none;
            margin-top: 8px;
        }
        table.signature td {
            border: none;
            padding: 0;
            vertical-align: top;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="dist/img/jatim.png" alt="logo">
        <p><strong>PEMERINTAH PROVINSI JAWA TIMUR</strong></p>
        <p><strong>DINAS KOMUNIKASI DAN INFORMATIKA</strong></p>
        <p>Jl. A. Yani No. 242-244 Surabaya Telp. (031) 8294608</p>
        <p>Website: kominfo.jatimprov.go.id | Email: kominfo@jatimprov.go.id</p>
        <p><strong><u>SURABAYA 60235</u></strong></p>
    </div><br>

    <h2 style="text-align: center;">PENILAIAN PESERTA MAGANG</h2>

    <table class="no-border" width="100%">
        <tr><td>Nama</td><td>{{ $rc->nama_peserta }}</td></tr>
        <tr><td>@if(optional($rc->permintaan->masterMgng->masterSklh)->jenis_sklh == 'pgt') NIM @else NIS @endif</td><td>{{ $rc->nis_peserta }}</td></tr>
        <tr><td>Lokasi Magang</td><td>Dinas Komunikasi dan Informatika Jawa Timur</td></tr>
        <tr><td>Unit/Bagian</td><td>{{ ($rc->notaDinas->masterBdng)->nama_bidang ?? 'Belum ditempatkan' }}</td></tr>
        <tr><td>Periode Magang</td><td>{{ \Carbon\Carbon::parse(optional($rc->permintaan->balasan)->tanggal_awal_magang ?? now())->translatedFormat('d F Y') }} s.d. {{ \Carbon\Carbon::parse(optional($rc->permintaan->balasan)->tanggal_akhir_magang ?? now())->translatedFormat('d F Y') }}</td></tr>
    </table><br>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Parameter</th>
                <th style="text-align:center">Bobot (%)</th>
                <th style="text-align:center">Angka</th>
                <th style="text-align:center">Nilai (Bobot x Skor)</th>
                <th style="text-align:center">Predikat</th>
            </tr>
        </thead>
        <tbody>
    <tr>
        <td style="text-align:center; font-weight: bold;">A</td><td colspan="5" style="text-align:left; font-weight: bold;">KEDISIPLINAN</td>
    </tr>
    <tr>
        <td style="text-align:center;">1.</td><td>Kehadiran dan Kepatuhan Tata Tertib</td><td align="center">6,67</td><td align="center">{{ $rc->nilai_kehadiran }}</td><td align="center">{{ number_format($rc->nilai_kehadiran * 0.0667,2) }}</td>
        <td align="center">
            @php
                $nilai = $rc->nilai_kehadiran;
                if ($nilai >= 91) echo 'Sangat Baik';
                elseif ($nilai >= 80) echo 'Baik';
                elseif ($nilai >= 70) echo 'Cukup';
                else echo 'Kurang';
            @endphp
        </td>
    </tr>
    <tr>
        <td style="text-align:center;">2.</td><td>Kerapian penampilan</td><td align="center">6,67</td><td align="center">{{ $rc->nilai_kerapian }}</td><td align="center">{{ number_format($rc->nilai_kerapian * 0.0667,2) }}</td>
        <td align="center">
            @php
                $nilai = $rc->nilai_kerapian;
                if ($nilai >= 91) echo 'Sangat Baik';
                elseif ($nilai >= 80) echo 'Baik';
                elseif ($nilai >= 70) echo 'Cukup';
                else echo 'Kurang';
            @endphp
        </td>
    </tr>
    <tr>
        <td style="text-align:center;">3.</td><td>Sikap/perilaku kerja</td><td align="center">10</td><td align="center">{{ $rc->nilai_sikap }}</td><td align="center">{{ number_format($rc->nilai_sikap * 0.1,2) }}</td>
        <td align="center">
            @php
                $nilai = $rc->nilai_sikap;
                if ($nilai >= 91) echo 'Sangat Baik';
                elseif ($nilai >= 80) echo 'Baik';
                elseif ($nilai >= 70) echo 'Cukup';
                else echo 'Kurang';
            @endphp
        </td>
    </tr>
    <tr>
        <td style="text-align:center;">4.</td><td>Tanggung jawab kerja</td><td align="center">6,67</td><td align="center">{{ $rc->nilai_tanggungjawab }}</td><td align="center">{{ number_format($rc->nilai_tanggungjawab * 0.0667,2) }}</td>
        <td align="center">
            @php
                $nilai = $rc->nilai_tanggungjawab;
                if ($nilai >= 91) echo 'Sangat Baik';
                elseif ($nilai >= 80) echo 'Baik';
                elseif ($nilai >= 70) echo 'Cukup';
                else echo 'Kurang';
            @endphp
        </td>
    </tr>
    <tr>
        <td style="text-align:center;">5.</td><td>Kepatuhan aturan dan tata tertib</td><td align="center">6,67</td><td align="center">{{ $rc->nilai_kepatuhan }}</td><td align="center">{{ number_format($rc->nilai_kepatuhan * 0.0667,2) }}</td>
        <td align="center">
            @php
                $nilai = $rc->nilai_kepatuhan;
                if ($nilai >= 91) echo 'Sangat Baik';
                elseif ($nilai >= 80) echo 'Baik';
                elseif ($nilai >= 70) echo 'Cukup';
                else echo 'Kurang';
            @endphp
        </td>
    </tr>

    <!-- Profesional -->
    <tr>
        <td style="text-align:center; font-weight: bold;">B</td><td colspan="5" style="text-align:left; font-weight: bold;">KREATIVITAS</td>
    </tr>
    <tr>
        <td style="text-align:center;">1.</td><td>Kemampuan komunikasi</td><td align="center">6,67</td><td align="center">{{ $rc->nilai_komunikasi }}</td><td align="center">{{ number_format($rc->nilai_komunikasi * 0.0667,2) }}</td>
        <td align="center">
            @php
                $nilai = $rc->nilai_komunikasi;
                if ($nilai >= 91) echo 'Sangat Baik';
                elseif ($nilai >= 80) echo 'Baik';
                elseif ($nilai >= 70) echo 'Cukup';
                else echo 'Kurang';
            @endphp
        </td>
    </tr>
    <tr>
        <td style="text-align:center;">2.</td><td>Kemampuan kerjasama</td><td align="center">6,67</td><td align="center">{{ $rc->nilai_kerjasama }}</td><td align="center">{{ number_format($rc->nilai_kerjasama * 0.0667,2) }}</td>
        <td align="center">
            @php
                $nilai = $rc->nilai_kerjasama;
                if ($nilai >= 91) echo 'Sangat Baik';
                elseif ($nilai >= 80) echo 'Baik';
                elseif ($nilai >= 70) echo 'Cukup';
                else echo 'Kurang';
            @endphp
        </td>
    </tr>
    <tr>
        <td style="text-align:center;">3.</td><td>Kemampuan memberikan ide/solusi/inisiatif</td><td align="center">6,67</td><td align="center">{{ $rc->nilai_inisiatif }}</td><td align="center">{{ number_format($rc->nilai_inisiatif * 0.0667,2) }}</td>
        <td align="center">
            @php
                $nilai = $rc->nilai_inisiatif;
                if ($nilai >= 91) echo 'Sangat Baik';
                elseif ($nilai >= 80) echo 'Baik';
                elseif ($nilai >= 70) echo 'Cukup';
                else echo 'Kurang';
            @endphp
        </td>
    </tr>

    <!-- Teknis -->
    <tr>
        <td style="text-align:center; font-weight: bold;">C</td><td colspan="5" style="text-align:left; font-weight: bold;">ASPEK TEKNIS</td>
    </tr>
    <tr>
        <td style="text-align:center;">1.</td><td>Nilai Teknis 1</td><td align="center">10</td><td align="center">{{ $rc->nilai_teknis1 }}</td><td align="center">{{ number_format($rc->nilai_teknis1 * 0.1,2) }}</td>
        <td align="center">
            @php
                $nilai = $rc->nilai_teknis1;
                if ($nilai >= 91) echo 'Sangat Baik';
                elseif ($nilai >= 80) echo 'Baik';
                elseif ($nilai >= 70) echo 'Cukup';
                else echo 'Kurang';
            @endphp
        </td>
    </tr>
    <tr>
        <td style="text-align:center;">2.</td><td>Nilai Teknis 2</td><td align="center">10</td><td align="center">{{ $rc->nilai_teknis2 }}</td><td align="center">{{ number_format($rc->nilai_teknis2 * 0.1,2) }}</td>
        <td align="center">
            @php
                $nilai = $rc->nilai_teknis2;
                if ($nilai >= 91) echo 'Sangat Baik';
                elseif ($nilai >= 80) echo 'Baik';
                elseif ($nilai >= 70) echo 'Cukup';
                else echo 'Kurang';
            @endphp
        </td>
    </tr>
    <tr>
        <td style="text-align:center;">3.</td><td>Nilai Teknis 3</td><td align="center">10</td><td align="center">{{ $rc->nilai_teknis3}}</td><td align="center">{{ number_format($rc->nilai_teknis3 * 0.1,2) }}</td>
        <td align="center">
            @php
                $nilai = $rc->nilai_teknis3;
                if ($nilai >= 91) echo 'Sangat Baik';
                elseif ($nilai >= 80) echo 'Baik';
                elseif ($nilai >= 70) echo 'Cukup';
                else echo 'Kurang';
            @endphp
        </td>
    </tr>
    <tr>
        <td style="text-align:center;">4.</td><td>Nilai Teknis 4</td><td align="center">10</td><td align="center">{{ $rc->nilai_teknis4 }}</td><td align="center">{{ number_format($rc->nilai_teknis4 * 0.1,2) }}</td>
        <td align="center">
            @php
                $nilai = $rc->nilai_teknis4;
                if ($nilai >= 91) echo 'Sangat Baik';
                elseif ($nilai >= 80) echo 'Baik';
                elseif ($nilai >= 70) echo 'Cukup';
                else echo 'Kurang';
            @endphp
        </td>
    </tr>

    <tr>
        <td colspan="5" align="right"><strong>Nilai Akhir</strong></td>
        <td align="center"><strong>{{ number_format($rc->nilai_akhir,2) }}</strong></td>
    </tr>
</tbody>

    </table>

    <div class="catatan">
        <p><strong>Catatan terkait 
            @if(optional($rc->permintaan->masterMgng->masterSklh)->jenis_sklh == 'pgt')
                mahasiswa
            @else
                siswa
            @endif
            {{ $rc->nama_peserta }} selama pelaksanaan magang:</strong></p>
        <p>{{ $rc->catatan ?? '-' }}</p>
    </div><br>

    <table class="signature" width="100%">
        <tr>
            <td style="width: 75%;"></td>
            <td align="center">
                Surabaya, {{ \Carbon\Carbon::parse(optional($rc->permintaan->balasan)->tanggal_akhir_magang ?? now())->translatedFormat('d F Y') }}<br>
                Pembimbing Lapangan<br><br><br><br><br><br>
                <u><b>{{ $rc->bdngMember->nama_pejabat ?? '-' }}</b></u><br>
                {{ $rc->bdngMember->jabatan_pejabat ?? '-' }}<br>
                NIP: {{ $rc->bdngMember->nip_pejabat ?? '-' }}
            </td>
        </tr>
    </table><br>

    <p style="font-size: 10px; margin-top: 10px;">Catatan: Lembar penilaian ini mohon diserahkan kepada peserta dalam amplop tertutup dan tersegel.</p>

</body>
</html>
