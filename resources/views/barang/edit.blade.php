@extends('master')
@section('title')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Ubah Data Barang</h4>
    </div>
    <div class="card-body">
        <div class="basic-form">
            <form action="{{ route('barang.update',$barang->barang_id)}}" method="post">
                @csrf
                @method('put')
                <label for="">Nama Barang</label>
                <div class="form-group">
                    <input type="text" class="form-control input-rounded" name="nama" value="{{ $barang->barang_nama ? $barang->barang_nama : old('nama')}}">
                </div>
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit">Ubah</button>
                    <a href="{{ route('barang.index')}}" class="btn btn-sm btn-outline-success">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
