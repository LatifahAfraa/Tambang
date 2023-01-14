@extends('master')
@section('title')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Lengkapi Data :</h4>
    </div>
    <div class="card-body">
        <div class="basic-form">
            <form action="{{ route('transaksi.update',$transaksi->transaksi_id)}}" method="post">
                @csrf
                @method('put')
                <label for="">Nama Driver</label>
                <div class="form-group">
                    <input type="text" class="form-control input-rounded" value="{{ $transaksi->member_nama }}" readonly>
                </div>
                <label for="">Kendaraan</label>
                <div class="form-group">
                    <select name="kendaraan" class="form-control" id="">
                        <option value="">-- Pilih --</option>
                        @foreach ($kendaraan as $item)
                            <option value="{{ $item->kendaraan_id }}">{{ $item->no_pol }} - {{ $item->brand }}</option>
                        @endforeach
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
@endsection
