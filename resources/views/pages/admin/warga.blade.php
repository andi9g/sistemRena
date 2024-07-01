@extends('layouts.admin')


@section('activewarga', 'active')

@section('judul', "Data Warga")


@section('content')
<div id="tambahwarga" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tambah-warga" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambah-warga">Form Tambah Warga</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('warga.store', []) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nik">NIK</label>
                        <input id="nik" class="form-control" type="number" placeholder="masukan nik" name="nik">
                    </div>
                    <div class="form-group">
                        <label for="namawarga">Nama Warga</label>
                        <input id="namawarga" class="form-control" type="text" placeholder="masukan nama lengkap" name="namawarga">
                    </div>
                    <div class="form-group">
                        <label for="blok">Blok Rumah</label>
                        <input id="blok" class="form-control" type="text" placeholder="masukan blok rumah" name="blokrumah">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <div class="row p-0">
        <div class="col-md-6">
            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#tambahwarga">
                <b>TAMBAH WARGA</b>
            </button>
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
                    <th>NIK</th>
                    <th>Nama Warga</th>
                    <th>Blok Rumah</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($warga as $item)
                <tr>
                    <td>{{ $loop->iteration + $warga->firstItem() - 1 }}</td>
                    <td>{{ $item->nik }}</td>
                    <td>{{ $item->namawarga }}</td>
                    <td>{{ $item->blokrumah }}</td>
                    <td nowrap>
                        <a href="{{ route('warga.destroy', [$item->idwarga]) }}" class="badge badge-danger badge-btn border-0" data-confirm-delete="true">
                            <i class="fa fa-trash"></i> Hapus
                        </a>

                        <button class="badge badge-info badge-btn border-0" type="button" data-toggle="modal" data-target="#ubahdata{{ $item->idwarga }}">
                            <i class="fa fa-edit"></i> Ubah
                        </button>
                    </td>
                </tr>

                <div id="ubahdata{{ $item->idwarga }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="my-modal-title">Ubah Data</h5>
                                <button class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('warga.update', [$item->idwarga]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="nik">NIK</label>
                                        <input id="nik" class="form-control" readonly type="number" value="{{ $item->nik }}" placeholder="masukan nik" name="nik">
                                    </div>
                                    <div class="form-group">
                                        <label for="namawarga">Nama Warga</label>
                                        <input id="namawarga" class="form-control" type="text" value="{{ $item->namawarga }}" placeholder="masukan nama lengkap" name="namawarga">
                                    </div>
                                    <div class="form-group">
                                        <label for="blok">Blok Rumah</label>
                                        <input id="blok" class="form-control" type="text" placeholder="masukan blok rumah" value="{{ $item->blokrumah }}" name="blokrumah">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">UBAH</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach

                @if (count($warga) == 0)
                    <tr>
                        <td colspan="4" class="text-center">Data Tidak Ditemukan</td>
                    </tr>
                @endif
            </tbody>
        </table>

    </div>


@endsection
