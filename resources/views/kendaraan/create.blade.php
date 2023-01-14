@extends('master')
@section('title')
@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Input Data Kendaraan</h4>
    </div>
    <div class="card-body">
        <div class="basic-form">
            <form action="{{ route('kendaraan.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="">Nama member</label>
                <div class="input-group mb-3">
                  <select class="form-select" id="inputGroupSelect01" name="member_id" >
                    @foreach($member as $baris)
                          <option value="{{ old('member_id') ? old ('member_id') : $baris->member_id }}">
                              {{ $baris->member_nama}}
                          </option>
                    @endforeach
                  </select>
                </div>

                <label for="">Nomor Polisi</label>
                <div class="form-group">
                    <input type="text" class="form-control " name="no_pol" placeholder=". . . . .">
                </div>
                <label for="">Jenis Kendaraan</label>
                <div class="form-group">
                    <input type="text" class="form-control input-rounded" name="jenis" placeholder=". . . . .">
                </div>
                <label for="">Tipe Kendaraan</label>
                <div class="form-group">
                    <input type="text" class="form-control input-rounded" name="type" placeholder=". . . . .">
                </div>
                <label for="">Brand Kendaraan</label>
                <div class="form-group">
                    <input type="text" class="form-control input-rounded" name="brand" placeholder=". . . . .">
                </div>
                <label for="">Foto Kendaraan</label>
                <div class="form-group">
                    <input type="file" class="form-control input-file" name="kendaraan_foto" placeholder=". . . . .">
                </div>


                
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit">Simpan</button>
                    <a href="{{ route('kendaraan.index')}}" class="btn btn-sm btn-outline-success">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
