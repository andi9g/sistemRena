@extends('layouts.admin')


@section('activekas', 'active')

@section('judul', "Data Kas")

@section('kembali')
<a href="{{ url('kas', []) }}" class="badge badge-danger badge-btn border-0">Halaman Sebelumnya</a>
@endsection

@section('content')

    <div class="row p-0">
        <div class="col-md-6">
            <table>
                <tr>
                    <td>Nama Warga</td>
                    <td class="px-2">:</td>
                    <td>{{ $warga->namawarga }}</td>
                </tr>
                <tr>
                    <td>Blok</td>
                    <td class="px-2">:</td>
                    <td>{{ $warga->blokrumah }}</td>
                </tr>
            </table>

        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#tambahkas"> + Tambah Pemasukan</button>
        </div>
    </div>
    <div id="tambahkas" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Tambah Pemasukan KAS</h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('kas.store', []) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="number" hidden value="{{ $warga->idwarga }}" name="idwarga">
                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <input id="tahun" class="form-control" readonly type="number" value="{{ date('Y') }}" name="tahun">
                        </div>

                        <div class="form-group">
                            <label for="bulan">Bulan</label>
                            <select id="bulan" class="form-control" name="bulan">
                                @foreach ($bulan as $b)
                                    <option value="{{ $b }}">{{ $b }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input id="tanggal" class="form-control" type="date" name="tanggal">
                        </div>

                        <div class="form-group">
                            <label for="jumlah">Jumlah Pembayaran</label>
                            <input id="jumlah" class="form-control" type="number" name="jumlahbayar">
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
                        <button type="submit" class="btn btn-success">TAMBAH PEMASUKAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="table-responsive mt-4">
        <table class="table table-hover table-striped table-bordered">
            <thead>
                <tr>
                    <th width="5px">No</th>
                    <th>Bulan</th>
                    <th>Tanggal</th>
                    <th>Jumlah Bayar</th>
                    <th>Ket</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($kas as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-bold"><b>{{ $item->bulan }}</b></td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat("dddd, DD MMMM Y") }}</td>
                        <td>Rp{{ number_format($item->jumlahbayar, 0, ",", ".") }}</td>
                        <td>
                            @if ($item->keterangan == "lunas")
                                <font class="text-success">LUNAS</font>
                            @elseif ($item->keterangan == "belum lunas")
                                <font class="text-danger">BELUM LUNAS</font>
                            @endif
                        </td>
                        <td nowrap>
                            <form action='{{ route('kas.destroy', [$item->idkas]) }}' method='post' class='d-inline'>
                                 @csrf
                                 @method('DELETE')
                                 <button type='submit' onclick="return confirm('Yakin ingin dihapus?')" class='badge badge-danger badge-btn border-0'>
                                     <i class="fa fa-trash"></i> Hapus
                                 </button>
                            </form>

                            <button class="badge badge-info badge-btn border-0" type="button" data-toggle="modal" data-target="#ubahkas{{ $item->idkas }}">
                                <i class="fa fa-edit"></i>Ubah
                            </button>
                        </td>
                    </tr>
                    <div id="ubahkas{{ $item->idkas }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="my-modal-title">Ubah Data KAS</h5>
                                    <button class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('kas.update', [$item->idkas]) }}" method="post">
                                    @csrf
                                    @method("PUT")
                                    <div class="modal-body">
                                        <input type="number" hidden value="{{ $warga->idwarga }}" name="idwarga">


                                        <div class="form-group">
                                            <label for="tanggal">Tanggal</label>
                                            <input id="tanggal" class="form-control" type="date" name="tanggal" value="{{ $item->tanggal }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="jumlah">Jumlah Pembayaran</label>
                                            <input id="jumlah" class="form-control" type="number" name="jumlahbayar" value="{{ $item->jumlahbayar }}">
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
                                        <button type="submit" class="btn btn-success">TAMBAH PEMASUKAN</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>

        </table>

    </div>


@endsection
