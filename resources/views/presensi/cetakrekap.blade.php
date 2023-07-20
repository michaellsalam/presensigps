<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>A4</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4
        }

        #title {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
        }

        .tabeldata {
            margin-top: 30px;
        }

        .tabeldata tr td {
            padding: 4px;
        }

        .tabelpresensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .tabelpresensi tr th {
            border: 1px solid #080808;
            padding: 5px;
            background-color: #eee9e9;
            font-size: 12px;
        }

        .tabelpresensi tr td {
            border: 1px solid #080808;
            padding: 5px;
            text-align: center;
            font-size: 12px;
        }

        .foto {
            width: 50px;
            height: 50px;
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4 landscape">

    <?php
    function selisih($jam_masuk, $jam_keluar)
    {
        [$h, $m, $s] = explode(':', $jam_masuk);
        $dtAwal = mktime($h, $m, $s, '1', '1', '1');
        [$h, $m, $s] = explode(':', $jam_keluar);
        $dtAkhir = mktime($h, $m, $s, '1', '1', '1');
        $dtSelisih = $dtAkhir - $dtAwal;
        $totalmenit = $dtSelisih / 60;
        $jam = explode('.', $totalmenit / 60);
        $sisamenit = $totalmenit / 60 - $jam[0];
        $sisamenit2 = $sisamenit * 60;
        $jml_jam = $jam[0];
        return $jml_jam . ':' . round($sisamenit2);
    }
    ?>

    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <table style="width: 100%">
            <tr>
                <td style="width: 30px">
                    <img src="{{ asset('assets/img/smkthpt.png') }}" width="90" height="90" alt="">
                </td>
                <td>
                    <h3 id="title">
                        Rekap Presensi <br>
                        Periode {{ strtoupper($namabulan[$bulan]) }} {{ $tahun }}<br>
                        SMK Tunas Harapan Pati <br>
                        <span><i>Jln. Raya Pati-Trangkil KM.4 Tlpn:(0295)382470 Fax:(0293)382234 Pati</i></span>
                    </h3>

                </td>
                <td style="width: 30px">
                    <img src="{{ asset('assets/img/urs_logo.png') }}" width="60" height="60" alt="">
                </td>
                <td style="width: 30px">
                    <img src="{{ asset('assets/img/logo_iso.png') }}" width="60" height="60" alt="">
                </td>
            </tr>
        </table>
        <table class="tabelpresensi">
            <tr>
                <th rowspan="2">NIK</th>
                <th rowspan="2">Nama Karyawan</th>
                <th colspan="31">Tanggal</th>
                <th rowspan="2">TH</th>
                <th rowspan="2">TT</th>
            </tr>
            <tr>
                <?php
                for ($i=1; $i <=31 ; $i++) {
                ?>
                <th>{{ $i }}</th>
                <?php
                }
                ?>
            </tr>
            @foreach ($rekap as $d)
                <tr>
                    <td>{{ $d->nik }}</td>
                    <td>{{ $d->nama_lengkap }}</td>

                    <?php
                    $totalhadir = 0;
                    $totalterlambat = 0;
                    for ($i=1; $i <=31 ; $i++) {
                        $tgl = "tgl_".$i;

                        if (empty($d->$tgl)) {
                            $hadir = ['',''];
                            $totalhadir += 0;
                        } else {
                            $hadir = explode("-", $d->$tgl);
                            $totalhadir += 1;
                            if ($hadir[0] > "07:00:00") {
                                $totalterlambat +=1;
                            }
                        }
                    ?>
                    <td>
                        <span style="color:{{ $hadir[0] > "07:00:00" ? "red":"" }}">{{ $hadir[0] }}</span>
                        <span style="color:{{ $hadir[1] <"16:00:00" ? "red":"" }}">{{ $hadir[1] }}</span>
                    </td>

                    <?php
                    }
                    ?>
                    <td>{{ $totalhadir }}</td>
                    <td>{{ $totalterlambat }}</td>
                </tr>
            @endforeach
        </table>

        <table width="100%" style="margin-top: 100px">
            <tr>
                <td></td>
                <td style="text-align: center">Pati, {{ date('d-m-Y') }}</td>
            </tr>
            <tr>
                <td style="text-align: center; vertical-align:bottom" height="100px">
                    <u>Michella Putri, S.E</u><br>
                    <i><b>Bendahara Sekolah</b></i>
                </td>
                <td style="text-align: center; vertical-align:bottom" height="100px">
                    <u>Ryza Putra Andi, M.Kom</u><br>
                    <i><b>Kepala Sekolah</b></i>
                </td>
            </tr>
        </table>

    </section>

</body>

</html>
