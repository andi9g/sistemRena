@extends('layouts.admin')


@section('activekas', 'active')

@section('judul', "Data Pemasukan KAS")


@section('content')

    <div class="row p-0">
        <div class="col-md-6">
        </div>
        <div class="col-md-6 ">
            <form action="{{ url()->current() }}" method="GET">
                <div class="input-group my-0">
                    <input class="form-control" type="text" name="keyword" value="{{ $keyword }}" placeholder="nama warga" aria-label="nama warga" aria-describedby="keword">
                    <div class="input-group-append">
                        <button type="submit" class="input-group-text bg-secondary text-light" id="keword">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="table-responsive mt-4">
        <table class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th width="5px">No</th>
                    <th>Nama Kas</th>
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
                            $jml = DB::table('kas')->where("tahun", date("Y"))->where("idwarga", $item->idwarga)->count();
                        @endphp
                        {{ $jml }} Kali Pembayaran
                    </td>
                    <td nowrap>
                        <a href="{{ route('kas.show', [$item->idwarga]) }}" class="badge badge-success badge-btn w-100">
                            KELOLA KAS
                        </a>
                    </td>

                </tr>
                @endforeach

                @if (count($warga) == 0)
                    <tr>
                        <td colspan="4" class="text-center">Data Tidak Ditemukan</td>
                    </tr>
                @endif
            </tbody>
        </table>

        {{ $warga->links("vendor.pagination.bootstrap-4") }}

    </div>


@endsection
