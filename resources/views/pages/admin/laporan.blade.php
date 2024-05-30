@extends('layouts.admin')


@section('activelaporan', 'active')

@section('judul', "Data Pengeluaran")


@section('content')
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Form Cetak Laporan</h5>
                </div>
                <form action="{{ route('cetak.laporan', []) }}" method="GET" target="_blank">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="tanggalawal">Tanggal Awal</label>
                            <input id="tanggalawal" class="form-control" type="date" name="tanggalawal">
                        </div>
                        <div class="form-group">
                            <label for="tanggalakhir">Tanggal Akhir</label>
                            <input id="tanggalakhir" class="form-control" type="date" name="tanggalakhir">
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <select id="keterangan" class="form-control text-capitalize" name="keterangan">
                                <option value="keseluruhan" class="text-capitalize">Keseluruhan</option>
                                <option value="pemasukan" class="text-capitalize">pemasukan</option>
                                <option value="pengeluaran" class="text-capitalize">pengeluaran</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Cetak</button>
                    </div>
                </form>
            </div>
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
