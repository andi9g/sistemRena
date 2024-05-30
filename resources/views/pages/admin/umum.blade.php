@extends('layouts.umum')

@section('content')
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container py-2">
        <a class="navbar-brand" href="#">
            <img src="{{ url('gambar', ['logo.jpeg']) }}" width="30" height="30" class="d-inline-block align-top rounded-circle mr-3" alt="">
            PONDOK KELAPA
          </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">


            </ul>
            <form class="form-inline my-2 my-lg-0">
            {{-- <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search"> --}}
                <a href="{{ url('login', []) }}" class="badge badge-btn badge-secondary my-2 my-sm-0 text-light" >LOGIN</a>
            </form>
        </div>

    </div>
</nav>



<div class="container mt-5 pt-5">
    <div class="jumbotron bg-white">
        <div class="row">
            <div class="col-md-9">
                <p style="font-size: 15pt;" align="justify">
                    Perumahan Pondok Kelapa adalah salah satu perumahan yang berlokasi di Tanjung Pinang, Kepulauan Riau. Perumahan ini terletak dilokasi strategis, dekat dengan pusat kota dan memiliki banyak fasilitas mulai dari akses mudah, dekat dengan tempat pendidikan hingga dekat dengan tempat belanja. Perumahan Pondok Kelapa beralamat di Jl. Kijang Lama, Melayu Kota Piring, Kec. Tanjungpinang Tim., Kota Tanjung Pinang, Kepulauan Riau.
                </p>
            </div>
            <div class="col-md-3">
                <img src="{{ url('gambar', ['logo.jpeg']) }}" width="100%" style="box-shadow: 2px 5px 2px rgba(0, 0, 0, 0.637);border:2px solid lightgrey" alt="">
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="jumbotron bg-light">
        <div class="row pb-10">
            <div class="col-xl-12 col-lg-12 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3" style="border: 1px solid darkgray">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark">Rp{{ number_format($totalkeuangan, 0, ",", ".") }}</div>
                            <div class="font-14 text-secondary weight-500">
                                TOTAL KEUANGAN
                            </div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#00eccf" style="color: rgb(0, 236, 207);">
                                <i class="icon-copy dw dw-calendar1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3" style="border: 1px solid darkgray">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark">Rp{{ number_format($kas, 0, ",", ".") }}</div>
                            <div class="font-14 text-secondary weight-500">
                                TOTAL PEMASUKAN KAS
                            </div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#ff5b5b" style="color: rgb(255, 91, 91);">
                                <span class="icon-copy ti-heart"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3" style="border: 1px solid darkgray">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark">Rp{{ number_format($tambahan, 0, ",", ".") }}</div>
                            <div class="font-14 text-secondary weight-500">
                                TOTAL PEMASUKAN TAMBAHAN
                            </div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon">
                                <i class="icon-copy fa fa-stethoscope" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3" style="border: 1px solid darkgray">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark">Rp{{ number_format($pengeluaran, 0, ",", ".") }}</div>
                            <div class="font-14 text-secondary weight-500">TOTAL PENGELUARAN</div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#09cc06" style="color: rgb(9, 204, 6);">
                                <i class="icon-copy fa fa-money" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8"><h5>HISTORI PEMASUKAN / PENGELUARAN</h5></div>
            <div class="col-md-4">
                    <div class='form-group'>
                        <input type='text' name='tahun' id='fortahun' class='form-control tahun' value="{{ $tahun }}">
                    </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
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
                    @foreach ($pemasukan as $item)
                    <tr>
                        <td>{{ $loop->iteration + $pemasukan->firstItem() - 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat("DD/MMMM/Y") }}</td>
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
                            @elseif ($item->jenispemasukan == "tambahan")
                                Rp{{ number_format($item->tambahan->jumlahbayar,0,",",".") }}
                            @else
                                -
                            @endif

                        </td>
                        <td>
                            @if ($item->jenispemasukan == "pengeluaran")
                                Rp{{ number_format($item->pengeluaran->jumlahkeluar,0,",",".") }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $pemasukan->links("vendor.pagination.bootstrap-4") }}
        </div>

    </div>
</div>



<div class="container" id="pencarian">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Detail Warga</h5>


            <div class="row p-0">
                <div class="col-md-6">
                    <h3>{{ $tahun }}</h3>
                </div>
                <div class="col-md-6 ">
                    <form action="#pencarian" method="GET">
                        <div class="input-group my-0">
                            <input class="form-control" type="text" name="keyword" value="{{ $keyword }}" placeholder="nama warga" aria-label="nama warga" aria-describedby="keword">
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text bg-secondary text-light" id="keword">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <div class="table-responsive mt-4" >
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="5px">No</th>
                            <th>Nama Warga</th>
                            <th>Blok Rumah</th>
                            <th>Jml. Pembayaran</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($warga as $item)
                        <tr>
                            <td>{{ $loop->iteration + $warga->firstItem() - 1 }}</td>
                            <td>{{ $item->namawarga }}</td>
                            <td>{{ $item->blokrumah }}</td>
                            <td>
                                @php
                                    $jml = DB::table('kas')->where("tahun", $tahun)->where("idwarga", $item->idwarga)->count();
                                @endphp
                                {{ $jml }} Kali Pembayaran
                            </td>
                            <td nowrap>
                                <button class="badge badge-btn badge-secondary border-0" type="button" data-toggle="modal" data-target="#detail{{ $item->idwarga }}">
                                    Detail Warga
                                </button>
                            </td>

                        </tr>

                        @endforeach

                        @if (count($warga) == 0)
                            <tr>
                                <td colspan="5" class="text-center">Data Tidak Ditemukan</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                {{ $warga->links("vendor.pagination.bootstrap-4") }}

            </div>
        </div>
    </div>
</div>



@foreach ($warga as $item)
<div id="detail{{ $item->idwarga }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="my-modal-title">Detail Warga</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <tr>
                            <th width="5px">No</th>
                            <th>Bulan</th>
                            <th>Tahun</th>
                            <th>Ket</th>
                        </tr>
                        @php
                            $detail = App\Models\kasM::where("idwarga", $item->idwarga)->where("tahun", $tahun)
                            ->orderBy("tanggal", "asc")->get();
                        @endphp
                        @foreach ($detail as $d)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $d->bulan }}</td>
                                <td>{{ $tahun }}</td>
                                <td>{{ $d->keterangan }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                Footer
            </div>
        </div>
    </div>
</div>


@endforeach

<div class="jumbotron mt-5">
    <div class="container">
        <h1 class="display-4">Contact Us</h1>
        <p class="lead"></p>
        <hr class="my-4">
        <a href="https://wa.me/+620895600285742" class="btn btn-success px-5">
            WA +620895600285742
        </a>

    </div>
</div>


@endsection

@section('myScript')
    <script>
        $(".tahun").yearpicker({
            year:{{ $tahun }},
            onChange : function(value){

                 // Get current URL parameters
                const urlParams = new URLSearchParams(window.location.search);
                const currentYear = urlParams.get('tahun');

                // Check if the selected year is different from the current parameter value
                if (currentYear !== value.toString()) {
                    // Redirect to a new URL with the selected year as a parameter
                    window.location.href = "?tahun=" + value;
                }
            }
        });
    </script>
@endsection
