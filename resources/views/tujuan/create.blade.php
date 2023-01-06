@extends('master')
@section('title')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Input Data Tujuan</h4>
    </div>
    <div class="card-body">
        <div class="basic-form">
            <form action="{{ route('tujuan.store')}}" method="post">
                @csrf
                <label for="">Nama Tujuan</label>
                <div class="form-group">
                    <input type="text" class="form-control input-rounded" name="nama" placeholder=". . . . .">
                </div>
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit">Simpan</button>
                    <a href="{{ route('tujuan.index')}}" class="btn btn-sm btn-outline-success">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
