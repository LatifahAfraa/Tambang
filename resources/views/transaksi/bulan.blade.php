@extends('master')
@section('title')
@section('content')
<div class="card table-responsive">
    <div class="card-body">
        <div class="mb-5">
            <form method="get" action="" class="form-inline float-right">
                <div class="input-group">
                    <select name="bulan" id="bulan" class="form-control">
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07">Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                    <input type="number" placeholder="Tahun" name="tahun" id="tahun" class="form-control">
                    <div class="input-group-prepend">
                        <button type="submit" class="btn btn-outline-primary ">Telusuri</button>
                    </div>
                </div>
            </form>
        </div>
        <br>
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
                    <th>Tujuan</th>
                    <th>Status</th>
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
                            @if( $item->tujuan_nama == NULL)
                                <strong>Belum Ada</strong>
                            @else
                            {{ $item->tujuan_nama}}
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#tahun').val("{{ $year}}")
        $('#bulan').val("{{ $month}}")
    });
</script>
@endsection
