@extends('layouts.admin')


@section('activeketuart', 'active')

@section('judul', "Data Warga")


@section('content')
<div id="tambahketuart" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="tambah-ketuart" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambah-ketuart">Form Tambah Warga</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('ketuart.store', []) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Ketua RT</label>
                        <input id="name" class="form-control" type="text" placeholder="masukan nama lengkap" name="name">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input id="username" class="form-control" type="text" placeholder="username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" class="form-control" type="text" placeholder="email" name="email">
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
            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#tambahketuart">
                <b>TAMBAH WARGA</b>
            </button>
        </div>
        <div class="col-md-6 ">
            <form action="{{ url()->current() }}" method="GET">
                <div class="input-group my-0">
                    <input class="form-control" type="text" name="keyword" value="{{ $keyword }}" placeholder="nama ketuart" aria-label="nama ketuart" aria-describedby="keword">
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
                    <th>Nama Warga</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($user as $item)
                <tr>
                    <td>{{ $loop->iteration}}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->username }}</td>
                    <td>
                        @if (Hash::check("admin".date("Y"), $item->password))
                            admin{{ date("Y") }}
                        @else
                            -
                        @endif
                    </td>
                    <td nowrap>
                        <a href="{{ route('ketuart.destroy', [$item->iduser]) }}" class="badge badge-danger badge-btn border-0" data-confirm-delete="true">
                            <i class="fa fa-trash"></i> Hapus
                        </a>

                        <button class="badge badge-info badge-btn border-0" type="button" data-toggle="modal" data-target="#ubahdata{{ $item->iduser }}">
                            <i class="fa fa-edit"></i> Ubah
                        </button>
                        <form action='{{ route('resetpassword.ketuart', [$item->iduser]) }}' method='post' class='d-inline'>
                             @csrf
                             @method('POST')
                             <button type='submit' class='badge badge-warning badge-btn border-0'>
                                 <i class="fa fa-key"></i> Reset
                             </button>
                        </form>
                    </td>
                </tr>

                <div id="ubahdata{{ $item->iduser }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="my-modal-title">Ubah Data</h5>
                                <button class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('ketuart.update', [$item->iduser]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="name">Nama Ketua RT</label>
                                        <input id="name" class="form-control" type="text" placeholder="masukan nama lengkap" value="{{ $item->name }}" name="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input id="username" class="form-control" type="text" placeholder="username" value="{{ $item->username }}" name="username">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" class="form-control" type="text" placeholder="email" value="{{ $item->email }}" name="email">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">UPDATE</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach

                @if (count($user) == 0)
                    <tr>
                        <td colspan="4" class="text-center">Data Tidak Ditemukan</td>
                    </tr>
                @endif
            </tbody>
        </table>

    </div>


@endsection
