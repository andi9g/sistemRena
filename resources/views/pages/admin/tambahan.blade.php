@extends('layouts.admin')


@section('activetambahan', 'active')

@section('judul', "Data Pemasukan Tambahan")


@section('content')
    <div id="tambahtambahan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Pemasukan Tambahan</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('tambahan.store', []) }}" method="post">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input id="nama" class="form-control" type="text" name="nama">
                        </div>

                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input id="tanggal" class="form-control" type="date" name="tanggal">
                        </div>

                        <div class="form-group">
                            <label for="perincian">Perincian</label>
                            <textarea id="perincian" class="form-control" style="height: auto" name="perincian" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="jumlahharga">Jumlah Uang (Rp)</label>
                            <input id="jumlahharga" class="form-control" type="number" name="jumlahbayar">
                        </div>

                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <br>
                            <input id="keterangan" class="" type="radio" name="keterangan" value="lunas">
                            <label for="">Lunas</label><br>
                            <input id="keterangan" class="" type="radio" name="keterangan" value="belum lunas">
                            <label for="">Belum Lunas</label>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">TAMBAH</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row p-0">
        <div class="col-md-6">
            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#tambahtambahan">
                Tambah Pemasukan Tambahan
            </button>
        </div>
        <div class="col-md-6 ">
            <form action="{{ url()->current() }}" method="GET">
                <div class="input-group my-0">
                    <input class="form-control" type="text" name="keyword" value="{{ $keyword }}" placeholder="berdasarkan nama " aria-label="nama warga" aria-describedby="keword">
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
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Perincian</th>
                    <th>Jml. Pembayaran</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($tambahan as $item)
                    <tr>
                        <td>{{ $loop->iteration + $tambahan->firstItem() - 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('dddd, DD MMMM Y') }}</td>
                        <td>{{ ucwords($item->nama) }}</td>
                        <td>{{ $item->perincian }}</td>
                        <td>Rp{{ number_format($item->jumlahbayar, 0, ",", ".") }}</td>
                        <td nowrap>
                            <form action='{{ route('tambahan.destroy', [$item->idtambahan]) }}' method='post' class='d-inline'>
                                 @csrf
                                 @method('DELETE')
                                 <button type='submit' onclick="return confirm('Yakin ingin menghapus?')" class='badge badge-danger badge-btn border-0'>
                                     <i class="fa fa-trash"></i>
                                 </button>
                            </form>
                            <button class="badge badge-info badge-btn border-0" type="button" data-toggle="modal" data-target="#ubahdata{{ $item->idtambahan }}">
                                <i class="fa fa-edit"></i> Ubah
                            </button>
                        </td>
                    </tr>
                    <div id="ubahdata{{ $item->idtambahan }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="my-modal-title">Ubah Data</h5>
                                    <button class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('tambahan.update', [$item->idtambahan]) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="nama">Nama Lengkap</label>
                                            <input id="nama" class="form-control" type="text" name="nama" value="{{ $item->nama }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="tanggal">Tanggal</label>
                                            <input id="tanggal" class="form-control" type="date" name="tanggal" value="{{ $item->tanggal }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="perincian">Perincian</label>
                                            <textarea id="perincian" class="form-control" style="height: auto" name="perincian" rows="3">{{ $item->perincian }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="jumlahharga">Jumlah Uang (Rp)</label>
                                            <input id="jumlahharga" class="form-control" type="number" name="jumlahbayar" value="{{ $item->jumlahbayar }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="keterangan">Keterangan</label>
                                            <br>
                                            <input id="keterangan" class="" type="radio" name="keterangan" value="lunas" @if ($item->keterangan == "lunas")
                                                checked
                                            @endif>
                                            <label for="">Lunas</label><br>
                                            <input id="keterangan" class="" type="radio" name="keterangan" value="belum lunas" @if ($item->keterangan == "belum lunas")
                                                checked
                                            @endif>
                                            <label for="">Belum Lunas</label>
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
            </tbody>
        </table>

        {{ $tambahan->links("vendor.pagination.bootstrap-4") }}

    </div>


@endsection
