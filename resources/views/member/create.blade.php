@extends('master')
@section('title')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Input Data Member</h4>
    </div>
    <div class="card-body">
        <div class="basic-form">
            <form action="{{ route('member.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="">Nama Member</label>
                <div class="form-group">
                    <input type="text" class="form-control input-rounded" name="member_nama" placeholder=". . . . .">
                </div>
                <label for="">Alamat Member</label>
                <div class="form-group">
                    <input type="text" class="form-control " name="member_alamat" placeholder=". . . . .">
                </div>
                <label for="">Email</label>
                <div class="form-group">
                    <input type="email" class="form-control input-rounded" name="member_email" placeholder=". . . . .">
                </div>
                <label for="">Password</label>
                <div class="form-group">
                    <input type="text" class="form-control input-rounded" name="password" placeholder=". . . . .">
                </div>
                <label for="">No HP</label>
                <div class="form-group">
                    <input type="number" class="form-control input-rounded" name="member_nohp" placeholder=". . . . .">
                </div>
                <label for="">Foto</label>
                <div class="form-group">
                    <input type="file" class="form-control input-file" name="member_foto" placeholder=". . . . .">
                </div>
               
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit">Simpan</button>
                    <a href="{{ route('tampil.member')}}" class="btn btn-sm btn-outline-success">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
