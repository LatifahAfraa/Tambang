@extends('master')
@section('title')
@section('content')
<div class="row">
    <div class="col-xl-3 mb-4 mb-xl-0">
        <a href="{{ route('member.create') }}" class="btn btn-primary light btn-lg btn-block rounded shadow px-2">+ Member</a>
    </div>
</div>
<br>
<div class="table-responsive">
    <table class="display example" style="min-width: 845px">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Email</th>
                <th>Nomor HP</th>
                <th>Foto</th>
                <th>-</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($member as $no => $item)
                <tr>
                    <td>{{ $no+1}}</td>
                    <td>{{$item->member_nama}}</td>
                    <td>{{$item->member_alamat}}</td>
                    <td>{{$item->member_email}}</td>
                    <td>{{$item->member_nohp}}</td>
                    <td>{{$item->member_foto}}</td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('member.edit',$item->member_id)}}" class="btn btn-outline-warning shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a>
                            <a href="{{ route('member.destroy',$item->member_id)}}" class="btn btn-danger shadow btn-xs sharp btn-hapus"><i class="fa fa-trash"></i></a>
                            <form action="{{ route('member.destroy',$item->member_id)}}" method="post">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
