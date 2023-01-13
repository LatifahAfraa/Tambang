@extends('master')
@section('title')
@section('content')
    <div class="card table-responsive">
        <div class="card-body">
            <center>
                <h2>List Point Sopir</h2>
            </center>
            <table class="example table table-bordered mt-2">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Supir</th>
                        <th>Jumlah Point</th>
                        <th>Sisa Point</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp

                    @foreach ($members as $key => $member)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $member->member_nama ?? "" }}</td>
                            <td>{{ $member->jumlah_point ?? 0 }}</td>
                            <td>{{ $member->point ?? 0 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
        </div>
    </div>
@endsection
