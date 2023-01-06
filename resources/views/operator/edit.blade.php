@extends('master')
@section('title')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Ubah Data Operator</h4>
    </div>
    <div class="card-body">
        <div class="basic-form">
            <form action="{{ route('operator.update',$operator->id)}}" method="post">
                @csrf
                @method('put')
                <label for="">Nama Operator</label>
                <div class="form-group">
                    <input type="text" class="form-control input-rounded" name="name" value="{{ $operator->name ? $operator->name : old('name')}}"">
                </div>
                <label for="">Username</label>
                <div class="form-group">
                    <input type="text" class="form-control input-rounded" name="username" value="{{ $operator->username ? $operator->username : old('username')}}">
                </div>
                <label for="">Password</label>
                <div class="form-group">
                    <input type="password" class="form-control input-rounded" name="password" placeholder=". . . . .">
                </div>
                <label for="">Konfirmasi Password</label>
                <div class="form-group">
                    <input type="password" class="form-control input-rounded" name="password_confirmation" placeholder=". . . . .">
                </div>
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit">Ubah</button>
                    <a href="{{ route('operator.index')}}" class="btn btn-sm btn-outline-success">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
