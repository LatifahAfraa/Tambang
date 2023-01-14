@extends('master')
@section('title')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Ubah Data Member</h4>
    </div>
    <div class="card-body">
        <div class="basic-form">
            <form action="{{ route('member.update',$member->member_id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <label for="">Nama Barang</label>
                <div class="form-group">
                    <input type="text" class="form-control input-rounded" name="member_nama" value="{{ $member->member_nama ? $member->member_nama : old('member_nama')}}">
                </div>
                <label for="">Alamat Member</label>
                <div class="form-group">
                    <input type="text" class="form-control " name="member_alamat" value="{{ $member->member_alamat ? $member->member_alamat : old('member_alamat')}}" placeholder=". . . . .">
                </div>
                <label for="">Email</label>
                <div class="form-group">
                    <input type="email" class="form-control input-rounded" name="member_email" value="{{ $member->member_email ? $member->member_email : old('member_email')}}" placeholder=". . . . .">
                </div>
                <label for="">Password</label>
                <div class="form-group">
                    <input type="text" class="form-control input-rounded" name="password" placeholder=". . . . .">
                </div>
                <label for="">No HP</label>
                <div class="form-group">
                    <input type="number" class="form-control input-rounded" name="member_nohp" value="{{ $member->member_nohp ? $member->member_nohp : old('member_nohp')}}" placeholder=". . . . .">
                </div>
                <label for="">Foto</label>
                <div class="form-group">
                    <input type="file" class="form-control input-file" name="member_foto" placeholder=". . . . .">
                </div>
                @error('Foto')
                <div class="alert alert-danger">{{ $message }}</div>   
               @enderror

                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit">Ubah</button>
                    <a href="{{ route('tampil.member')}}" class="btn btn-sm btn-outline-success">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
