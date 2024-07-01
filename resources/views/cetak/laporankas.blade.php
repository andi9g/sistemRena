<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Laporan</title>

    <style>
        @page {
            margin-top: 30px;
        }
        body {
            margin: 0;
            padding: 0;
        }
        table {
            border-collapse: collapse;
        }
        h1 {
            margin: 0;
            padding: 0;
        }
        p {
            margin: 0;
            padding: 0;
            font-size: 10pt;
        }
    </style>
</head>
<body>

    <table style="border-bottom: 2px double rgb(63, 63, 63);padding-bottom: 20px " width="100%">
        <tr>
            {{-- <td width="90px" valign="top">
                <img src="{{ url('gambar', ['logo.jpeg']) }}" width="100%" style="border:1px solid lightgrey;box-shadow: 2px 5px 2px darkgrey;border-radius: 50%" alt="">
            </td> --}}
            <td valign="middle" style="padding-left: 20px">
                <h1>PONDOK KELAPA</h1>
                <p>Jl. Kijang Lama, Melayu Kota Piring, Kec. Tanjungpinang Tim., Kota Tanjung Pinang, Kepulauan Riau.</p>
            </td>
        </tr>
    </table>
<small>
    <table>
        <tr>
            <td>Hal</td>
            <td>:</td>
            <td>Laporan KAS Warga</td>
        </tr>
        <tr>
            <td>Priode</td>
            <td>&emsp;&emsp;:&nbsp;</td>
            <td>{{ \Carbon\Carbon::parse($bulan)->isoFormat("MMMM")." (".\Carbon\Carbon::parse($bulan)->isoFormat("Y").")" }}</td>
        </tr>
    </table>

</small>



    <table width="100%" border="1">
        <thead>
            <tr>
                <th width="5px">No</th>
                <th>Nama Warga</th>
                <th>Blok Rumah</th>
                <th>Status Pembayaran</th>
            </tr>
        </thead>

        <tbody>
            @php
                $totalpemasukan = 0;
                $totalpengeluaran = 0;
            @endphp
            @foreach ($data as $item)
            <tr>
                <td align="center">{{ $loop->iteration}}</td>
                <td>{{ $item["namawarga"] }}</td>
                <td>
                    {{ $item["blokrumah"] }}
                </td>
                <td>
                    <b>
                        @if ($item["status"] == 1)
                            <font style="color:green">LUNAS</font>
                        @else
                            <font style="color:red">BELUM LUNAS</font>
                        @endif
                    </b>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">TELAH LUNAS</th>
                <th >
                    {{ $lunas }}
                </th>
            </tr>
            <tr>
                <th colspan="3">BELUM LUNAS</th>
                <th >
                    {{ $belumlunas }}
                </th>
            </tr>
        </tfoot>
    </table>
    <br>

    <table width="100%">
        <tr>
            <td width="65%"></td>
            <td>
                Tanjungpinang, {{ \Carbon\Carbon::parse(date("Y-m-d"))->isoFormat("DD MMMM Y") }} <br>
                ADMIN
                <br><br><br><br>

                . . . . . . . . . . . . . . . . . . . . . . . .
            </td>
            {{-- <td width="5%"></td> --}}
        </tr>
    </table>

</body>
</html>
