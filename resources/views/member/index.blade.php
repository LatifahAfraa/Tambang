@extends('master')
@section('title')
@section('content')

<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="approve-tab" data-toggle="tab" href="#approve" role="tab" aria-controls="approve"
                    aria-selected="false">Approve</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pengajuan-tab" data-toggle="tab" href="#pengajuan" role="tab"
                    aria-controls="pengajuan" aria-selected="true">Pengajuan</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade" id="pengajuan" role="tabpanel" aria-labelledby="pengajuan-tab">
                <br>
                <table class="display example" style="min-width: 845px">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>No. Ponsel</th>
                            <th>Alamat</th>
                            <th>Foto</th>
                            <th>-</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($member as $item)
                            @if ($item->member_status == 0)
                                <tr>
                                    <td>{{$item->member_nama}}</td>
                                    <td>{{$item->member_nohp}}</td>
                                    <td>{{$item->member_alamat}}</td>
                                    <td><img src="{{ asset('member/'.$item->member_foto)}}" alt=""></td>
                                    <td>
                                        <a href="{{ route('member.status',[$item->member_id,1])}}" class="btn btn-sm shadow btn-success">Terima</a>
                                        &nbsp;&nbsp;
                                        <a href="{{ route('member.status',[$item->member_id,2])}}" class="btn btn-sm shadow btn-danger">Tolak</a>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade show active" id="approve" role="tabpanel" aria-labelledby="approve-tab">
                <br>
                <table class="display example" style="min-width: 845px">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>No. Ponsel</th>
                            <th>Alamat</th>
                            <th>Foto</th>
                            <th>-</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($member as $item)
                            @if ($item->member_status == 1)
                                <tr>
                                    <td>{{$item->member_nama}}</td>
                                    <td>{{$item->member_nohp}}</td>
                                    <td>{{$item->member_alamat}}</td>
                                    <td>
                                        <div class="profile-photo">
                                            <img src="{{ asset('member/'.$item->member_foto)}}" width="100" class="img-fluid rounded-circle"
                                                alt="">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('member.show',$item->member_id)}}" class="btn btn-outline-info shadow btn-xs sharp mr-1"><i class="fa fa-search"></i></a>
                                            <a href="{{ route('member.destroy',$item->member_id)}}" class="btn btn-danger shadow btn-xs sharp mr-1 btn-hapus"><i class="fa fa-trash"></i></a>
                                            <form action="{{ route('member.destroy',$item->member_id)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
