@extends('master')
@section('title')
@section('content')

<div class="row">
    <div class="col-xl-3 mb-4 mb-xl-0">
        <a href="{{ route('adminAb.create.op2')}}" class="btn btn-primary light btn-lg btn-block rounded shadow px-2">Checkin</a>
    </div>
</div>
<br>

<div class="card table-responsive">
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
                        <td>{{ date('H:i:s', strtotime($item->check_out))}}</td>
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
                            @if ($item->status_transaksi == 0)
                                <span class="badge badge-warning">Proses</span>
                            @elseif($item->status_transaksi == 1)
                                <span class="badge badge-success">Sukses</span>
                            @else
                                <span class="badge badge-danger">Batal</span>
                            @endif
                        </td>
                        <td>
                            @if ($item->status_transaksi == 0)
                            <div class="d-flex">
                                <span class="badge badge-danger">Belum Check-Out</span>
                            </div>
                            @else
                            -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection