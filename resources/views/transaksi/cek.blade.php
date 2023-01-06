@extends('master')
@section('title')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Lengkapi Data :</h4>
    </div>
    <div class="card-body">
        <div class="basic-form">
            <form action="{{ route('transaksi.ceks',$transaksi->transaksi_id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <label for="">Nama Driver</label>
                <div class="form-group">
                    <input type="text" class="form-control input-rounded" value="{{ $transaksi->member_nama }}" readonly>
                </div>
                <label for="">Kendaraan</label>
                <div class="form-group">
                    <select name="kendaraan" class="form-control" id="kendaraan" required>
                        <option value="NULL">-- Pilih --</option>
                        @foreach ($kendaraan as $item)
                            <option value="{{ $item->kendaraan_id }}">{{ $item->no_pol }} - {{ $item->brand }}</option>
                        @endforeach
                    </select>
                </div>
                <label for="">Barang / Muatan</label>
                <div class="form-group">
                    <select name="barang" class="form-control" id="barang" required>
                        <option value="NULL">-- Pilih --</option>
                        @foreach ($barang as $item)
                            <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                        @endforeach
                    </select>
                </div>
                <label for="">Quantity</label>
                <div class="form-group">
                    <input type="number" class="form-control input-rounded" value="{{ $transaksi->qty }}" name="qty" required>
                </div>
                <label for="">Satuan</label>
                <div class="form-group">
                    <select name="satuan" class="form-control" id="satuan" required>
                        <option value="NULL">-- Pilih --</option>
                        @foreach ($satuan as $item)
                            <option value="{{ $item->satuan_id }}">{{ $item->satuan_nama }}</option>
                        @endforeach
                    </select>
                </div>
                <label for="">Foto Barang</label>
                <div class="form-group">
                    <input type="file" class="form-control input-rounded" name="foto">
                </div>
                <label for="">Tujuan</label>
                <div class="form-group">
                    <select name="tujuan" class="form-control" id="tujuan">
                        <option value="NULL">-- Pilih --</option>
                        @foreach ($tujuan as $item)
                            <option value="{{ $item->tujuan_id }}">{{ $item->tujuan_nama }}</option>
                        @endforeach
                    </select>
                </div>
                <label for="">Status</label>
                <div class="form-group">
                    <select name="status" class="form-control" id="status" required>
                        <option value="0">-- Pilih --</option>
                        <option value="1">Terima</option>
                        <option value="2">Tolak</option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit">Ubah</button>
                    <a href="{{ route('transaksi.index')}}" class="btn btn-sm btn-outline-success">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#kendaraan').val("{{ $transaksi->kendaraan_id }}")
        $('#barang').val("{{ $transaksi->barang_id }}")
        $('#satuan').val("{{ $transaksi->satuan_id }}")
        $('#status').val("{{ $transaksi->status_transaksi }}")
    });
</script>
@endsection
