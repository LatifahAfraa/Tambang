@extends('master')
@section('title')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Ubah Data Satuan</h4>
    </div>
    <div class="card-body">
        <div class="basic-form">
            <form action="{{ route('satuan.update',$satuan->satuan_id)}}" method="post">
                @csrf
                @method('put')
                <label for="">Nama Satuan</label>
                <div class="form-group">
                    <input type="text" class="form-control input-rounded" name="nama" value="{{ $satuan->satuan_nama ? $satuan->satuan_nama : old('nama')}}">
                </div>
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit">Ubah</button>
                    <a href="{{ route('satuan.index')}}" class="btn btn-sm btn-outline-success">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
