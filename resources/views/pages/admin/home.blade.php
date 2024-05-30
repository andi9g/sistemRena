@extends('layouts.admin')


@section('activehome', 'active')
@section('judul', "HOME")


@section('content')
<div class="row pb-10">
    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
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
    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
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
    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
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
    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
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
