@extends('layouts.admin')


@section('activelaporankas', 'active')

@section('judul', "LAPORAN KEUANGAN")


@section('content')
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Form Cetak Laporan</h5>
                </div>
                <form action="{{ route('cetak.laporankas', []) }}" method="GET" target="_blank">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="tahun">Text</label>
                            <input id="tahun" class="form-control" type="number" name="tahun" value="{{ $tahun }}">
                        </div>
                        <div class='form-group'>
                            <label for='forbulan' class='text-capitalize'>Bulan</label>
                            <select name='bulan' id='forbulan' class='form-control'>
                                <option value='01'>Januari</option>
                                <option value='02'>Februari</option>
                                <option value='03'>Maret</option>
                                <option value='04'>April</option>
                                <option value='05'>Mei</option>
                                <option value='06'>Juni</option>
                                <option value='07'>Juli</option>
                                <option value='08'>Agustus</option>
                                <option value='09'>September</option>
                                <option value='10'>Oktober</option>
                                <option value='11'>November</option>
                                <option value='12'>Desember</option>
                            <select>
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
