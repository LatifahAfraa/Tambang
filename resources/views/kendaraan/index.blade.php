@extends('master')
@section('title')
@section('content')
    <div class="row">
        <div class="col-xl-3 mb-4 mb-xl-0">
            <a href="{{ route('kendaraan.create') }}" class="btn btn-primary light btn-lg btn-block rounded shadow px-2">+
                Kendaran</a>
        </div>
    </div>
    <br>
    <div class="table-responsive">
        <table class="display example" style="min-width: 845px">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Member</th>
                    <th>No. Polisi</th>
                    <th>Jenis</th>
                    <th>Type</th>
                    <th>Brand</th>
                    <th>Foto</th>
                    <th>Aktif</th>
                    <th>-</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kendaraan as $no => $item)
                    <tr>
                        <td>{{ $no + 1 }}</td>
                        <td>{{ $item->member_nama }}</td>
                        <td>{{ $item->no_pol }}</td>
                        <td>{{ $item->jenis }}</td>
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->brand }}</td>
                        <td>
                            <button type="button" class="btn btn-outline-primary btn-xs shadow" data-toggle="modal"
                                data-target="#foto{{ $item->kendaraan_id }}">
                                <i class="fa fa-search"></i>
                            </button>
                        </td>
                        <td>
                            @if ($item->kendaraan_aktif == 1)
                                <span class="badge badge-danger">Tidak Aktif</span>
                            @else
                                <span class="badge badge-success">Aktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('kendaraan.destroy', $item->kendaraan_id) }}"
                                class="btn btn-danger shadow btn-xs sharp mr-1 btn-hapus"><i class="fa fa-trash"></i></a>
                            <form action="{{ route('kendaraan.destroy', $item->kendaraan_id) }}" method="post">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="foto{{ $item->kendaraan_id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <center>
                                        <img src="{{ asset('kendaraan/' . $item->kendaraan_foto) }}" alt=""
                                            class="img-fluid">
                                    </center>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
