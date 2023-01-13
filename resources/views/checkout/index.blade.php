@extends('master')
@section('title')
@section('content')

    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="approve-tab" data-toggle="tab" href="#approve" role="tab"
                        aria-controls="approve" aria-selected="false">Approve</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pengajuan-tab" data-toggle="tab" href="#pengajuan" role="tab"
                        aria-controls="pengajuan" aria-selected="true">Pengajuan</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade" id="pengajuan" role="tabpanel" aria-labelledby="pengajuan-tab">
                    <br>
                    <table class="example">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kendaraan</th>
                                <th>In</th>
                                <th>Out</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>-</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi as $item)
                                @if ($item->status_transaksi != 1 )
                                    <tr>
                                        <td>{{ $item->member_nama }}</td>
                                        <td>
                                            @if ($item->kendaraan_id == null)
                                                <strong>Silahkan Lengkapi Data</strong>
                                            @else
                                                <span class="badge badge-info">{{ $item->no_pol }} -
                                                    {{ $item->brand }}</span>
                                            @endif
                                        </td>
                                        <td>{{ date('d-F-Y H:i:s', strtotime($item->check_in)) }}</td>
                                        <td>{{ date('d-F-Y H:i:s', strtotime($item->check_out)) }}</td>
                                        <td>
                                            @if ($item->status_transaksi == 0)
                                                <span class="badge badge-warning">Proses</span>
                                            @elseif($item->status_transaksi == 1)
                                                <span class="badge badge-success">Diterima</span>
                                            @else
                                                <span class="badge badge-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->keterangan }}</td>
                                        <td>
                                            <a href="{{ route('checkout.status',[$item->transaksi_id,1])}}"
                                                class="btn btn-sm shadow btn-success">Terima</a>
                                            &nbsp;&nbsp;
                                            <a href="{{ route('checkout.status',[$item->transaksi_id,2])}}"
                                                class="btn btn-sm shadow btn-danger">Tolak</a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade show active" id="approve" role="tabpanel" aria-labelledby="approve-tab">
                    <br>
                    <table class="display example">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kendaraan</th>
                                <th>In</th>
                                <th>Out</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksi as $item)
                                @if ($item->status_transaksi == 1 && 2)
                                <tr>
                                    <td>{{ $item->member_nama }}</td>
                                    <td>
                                        @if ($item->kendaraan_id == null)
                                            <strong>Silahkan Lengkapi Data</strong>
                                        @else
                                            <span class="badge badge-info">{{ $item->no_pol }} -
                                                {{ $item->brand }}</span>
                                        @endif
                                    </td>
                                    <td>{{ date('d-F-Y H:i:s', strtotime($item->check_in)) }}</td>
                                    <td>{{ date('d-F-Y H:i:s', strtotime($item->check_out)) }}</td>
                                    <td>
                                        @if ($item->status_transaksi == 0)
                                            <span class="badge badge-warning">Proses</span>
                                        @elseif($item->status_transaksi == 1)
                                            <span class="badge badge-success">Diterima</span>
                                        @else
                                            <span class="badge badge-danger">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
