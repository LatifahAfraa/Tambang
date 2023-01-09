@extends('master')
@section('title')
@section('content')
    <div class="card table-responsive">
        <div class="card-body">
            <div class="mb-5">
                <center>
                    <h2> Koppaska (Koperasi Jasa Pengusaha Pasir Silika)<br>
                        Laporan Ritase Barang per Pelanggan<br>
                        Dari {{ date("d F Y", $start) }} s/d {{ date("d F Y", $end) }}
                    </h2>
                </center>
                <form method="get" action="" class="form-inline float-right">
                    <div class="input-group">
                        <input type="text" placeholder="Tahun" name="tahun" id="tahun" class="form-control input-daterange-datepicker" value="{{ request()->tahun ?? "" }}">
                        <div class="input-group-prepend">
                            <button type="submit" class="btn btn-outline-primary ">Telusuri</button>
                        </div>
                    </div>
                </form>
            </div>
            <br>
            <a href="{{ route('cetak.barang.perpelanggan', ['tahun' => request()->tahun ?? ""]) }}" class="btn btn-primary" target="_blank">CETAK PDF</a>
            <a href="{{ route('excel.barang.perpelanggan', ['tahun' => request()->tahun ?? ""]) }}" class="btn btn-success" target="_blank">CETAK EXCEL</a>
            <br>
            <table class="table table-bordered mt-2">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Nama Pelanggan</th>
                        <th>Jumlah Ritase</th>
                        <th>Total</th>

                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                        $total_keseluruhan = 0;
                    @endphp
                    @foreach ($barang_perpelanggan as $barang => $member_lists)
                        @php
                            $total_barang = 0;
                            $members = [];
                        @endphp

                        @foreach ($member_lists as $key => $item)
                            @php
                                $members[] = [
                                    'nama' => $key,
                                    'qty' => $item->sum('qty') ?? 0
                                ];
                                $total_barang += $item->sum('qty') ?? 0;
                            @endphp
                        @endforeach
                        @php
                            $total_keseluruhan += $total_barang;
                        @endphp
                        <tr>
                            <td rowspan="{{ $member_lists->count() }}">{{ $no++ }}</td>
                            <td rowspan="{{ $member_lists->count() }}">{{ $barang ?? "" }}</td>
                            <td>{{ $members[0]['nama'] }}</td>
                            <td>{{ $members[0]['qty'] }}</td>
                            <td rowspan="{{ $member_lists->count() }}">{{ $total_barang ?? 0 }}</td>
                        </tr>



                        @foreach ($members as $key => $member)
                            @if ($key != 0)
                                <tr>
                                    <td>{{ $member['nama'] ?? "" }}</td>
                                    <td>{{ $member['qty'] ?? 0 }}</td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4">Total Keseluruhan</th>
                        <th>{{ $total_keseluruhan }}</th>
                    </tr>
                </tfoot>
            </table>
            <br>
        </div>
    </div>
@endsection
