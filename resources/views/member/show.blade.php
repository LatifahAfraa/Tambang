@extends('master')
@section('title')
@section('content')
<div class="card">
    <div class="card-body">
        <center>
            <h2>{{ $member->member_nama}}</h2>
        </center>
        <div class="row">
            <div class="col-4">
                <img src="{{ asset('member/'.$member->member_foto)}}" class="img-fluid" alt="">
            </div>
            <div class="col-8">
                <p>
                    <strong>No. Ponsel</strong> : {{$member->member_nohp}}
                </p>
                <p>
                    <strong>Email</strong> : {{$member->member_email}}
                </p>
                <p>
                    <strong>Alamat</strong> : {{$member->member_alamat}}
                </p>
                <p>
                    <strong>Point</strong> : {{$member->point}}
                </p>
                <p>
                    <strong>Aktif</strong> :
                    @if ($member->member_aktif == 0)
                        <span class="badge badge-success">Aktif</span>
                    @else
                        <span class="badge badge-danger">Tidak Aktif</span>
                    @endif
                </p>
                <hr>
                <p>
                    <div class="d-flex">
                        <a href="{{route('member.index')}}" class="btn btn-sm shadow btn-outline-success">Kembali</a>&nbsp;&nbsp;
                        <button type="button" class="btn btn-sm shadow btn-primary" data-toggle="modal" data-target="#potong">
                            Claim Point
                        </button>
                    </div>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="card table-responsive">
    <div class="card-header">
        <div class="card-body">
            <table class="display example" style="min-width: 845px">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Kendaraan</th>
                        <th>In</th>
                        <th>Out</th>
                        <th>Qty</th>
                        <th>Muatan</th>
                        <th>Foto</th>
                        <th>Status</th>
                        <th>-</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi as $no => $item)
                        @if ($item->check_out && $item->status_transaksi != 0)
                            <tr>
                                <td>{{$item->no_urut}}</td>
                                <td>{{$item->member_nama}}</td>
                                <td>
                                    @if ($item->kendaraan_id == NULL)
                                        <strong>Silahkan Lengkapi Data</strong>
                                    @else
                                        <span class="badge badge-info">{{ $item->no_pol }} - {{ $item->brand }}</span>
                                    @endif
                                </td>
                                <td>{{ date('d-F-Y H:i:s', strtotime($item->check_in))}}</td>
                                <td>{{ date('d-F-Y H:i:s', strtotime($item->check_out))}}</td>
                                <td>{{ $item->qty}}</td>
                                <td>{{ $item->barang_nama}} - {{ $item->satuan_nama }}</td>
                                <td>
                                    @if ($item->foto_barang == NULL)
                                        <strong>Belum Ada</strong>
                                    @else
                                        <img src="{{ asset('bukti/'.$item->foto_barang) }}" alt="">
                                    @endif
                                </td>
                                <td>
                                    @if($item->status_transaksi == 1)
                                        <span class="badge badge-success">Sukses</span>
                                    @else
                                        <span class="badge badge-danger">Batal</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('transaksi.cek',$item->transaksi_id)}}" class="btn btn-outline-info shadow btn-xs sharp mr-1"><i class="fa fa-search"></i></a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="potong" tabindex="-1" role="dialog" aria-labelledby="potongLabel" aria-hidden="true">
    <form action="{{ route('member.point',$member->member_id)}}" method="post">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="potongLabel">Pemotongan Point Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Jumlah Point :</label>
                    <input type="number" name="point" class="form-control" max="{{$member->point}}" min="0">
                </div>
                <div class="form-group">
                    <label for="">Keterangan :</label>
                    <input type="text" name="keterangan" class="form-control" placeholder="Berikan keterangan . . .">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Potong</button>
            </div>
            </div>
        </div>
    </form>
</div>
@endsection
