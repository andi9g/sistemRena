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
            <td width="90px" valign="top">
                <img src="{{ url('gambar', ['logo.jpeg']) }}" width="100%" style="border:1px solid lightgrey;box-shadow: 2px 5px 2px darkgrey;border-radius: 50%" alt="">
            </td>
            <td valign="middle" style="padding-left: 20px">
                <h1>PONDOK KELAPA</h1>
                <p>Jl. Kijang Lama, Melayu Kota Piring, Kec. Tanjungpinang Tim., Kota Tanjung Pinang, Kepulauan Riau.</p>
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td>Hal</td>
            <td>:</td>
            <td>Laporan {{ $keterangan }}</td>
        </tr>
        <tr>
            <td>Priode</td>
            <td>&emsp;&emsp;:&nbsp;</td>
            <td>{{ \Carbon\Carbon::parse($tanggalawal)->isoFormat("DD MMMM Y"). " s.d ".\Carbon\Carbon::parse($tanggalakhir)->isoFormat("DD MMMM Y") }}</td>
        </tr>
    </table>



    <table width="100%" border="1">
        <thead>
            <tr>
                <th width="5px">No</th>
                <th>Tanggal</th>
                <th>Perincian</th>
                <td>Pemasukan</td>
                <td>Pengeluaran</td>
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
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat("DD MMMM Y") }}</td>
                <td>
                    @if ($item->jenispemasukan == "kas")
                        PEMASUKAN KAS
                    @elseif ($item->jenispemasukan == "tambahan")
                        {{ $item->tambahan->perincian }}
                    @elseif ($item->jenispemasukan == "pengeluaran")
                        {{ $item->pengeluaran->perincian }}

                    @endif
                </td>
                <td>
                    @if ($item->jenispemasukan == "kas")
                        Rp{{ number_format($item->kas->jumlahbayar,0,",",".") }}
                    @php
                        $totalpemasukan = $totalpemasukan + $item->kas->jumlahbayar;
                    @endphp
                    @elseif ($item->jenispemasukan == "tambahan")
                        Rp{{ number_format($item->tambahan->jumlahbayar,0,",",".") }}
                    @php
                        $totalpemasukan = $totalpemasukan + $item->tambahan->jumlahbayar;
                    @endphp
                    @else
                        -
                    @endif

                </td>
                <td>
                    @if ($item->jenispemasukan == "pengeluaran")
                        Rp{{ number_format($item->pengeluaran->jumlahkeluar,0,",",".") }}
                        @php
                        $totalpengeluaran = $totalpengeluaran + $item->pengeluaran->jumlahkeluar;
                    @endphp
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">TOTAL KESELURUHAN</th>
                <th >
                    Rp{{ number_format($totalpemasukan,0,",",".") }}
                </th>
                <th >
                    Rp{{ number_format($totalpengeluaran,0,",",".") }}
                </th>
            </tr>
        </tfoot>
    </table>

</body>
</html>
