@extends('master')
@section('title')
@section('content')
    <div class="card table-responsive">
        <div class="card-body">
            <center><h2>List Point Sopir</h2></center>
            <table class="example table table-bordered mt-2">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Supir</th>
                        <th>Jumlah Point</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp

                    @foreach ($point_sopir as $item )
                        @if ($item->member_alamat != 'Padang')
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->member_nama }}</td>
                                <td>{{ $item->point}}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <br>
        </div>
    </div>
@endsection
