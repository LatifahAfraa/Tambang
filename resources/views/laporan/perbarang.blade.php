@extends('master')
@section('title')
@section('content')
    <div class="card table-responsive">
        <div class="card-body">
            <div class="mb-5">
                <center>
                    <h2> Koppaska (Koperasi Jasa Pengusaha Pasir Silika)<br>
                        Laporan Ritase per Barang<br>
                        Dari {{ date("d F Y", $start) }} s/d {{ date("d F Y", $end) }}
                    </h2>
                </center>
                <form method="get" action="" class="form-inline float-right">
                    <div class="input-group">
                        <input type="text" placeholder="Tahun" name="tahun" id="tahun" class="form-control input-daterange-datepicker" value="{{ request()->tahun ?? "" }}">
                        <div class="input-group-prepend">
                            <button type="submit" class="btn btn-outline-primary ">Telusuri</button>
                        </div>
                    </div>
                </form>
            </div>
            <br>
            <a href="{{ route('cetak.perbarang', ['tahun' => request()->tahun ?? ""]) }}" class="btn btn-primary" target="_blank">CETAK PDF</a>
            <a href="{{ route('excel.perbarang', ['tahun' => request()->tahun ?? ""]) }}" class="btn btn-success" target="_blank">CETAK EXCEL</a>
            <br>

            <table class="table table-bordered mt-2">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Satuan</th>
                        <th>Jumlah Ritase</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                        $total_keseluruhan = 0;

                    @endphp
                    @foreach ($perbarang as $barang => $satuans )
                        @foreach ($satuans as $satuan => $items)
                        @php
                            $total_keseluruhan += $items->sum('qty');
                        @endphp
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $barang }}</td>
                                <td>{{ $satuan }}</td>
                                <td>{{ $items->sum('qty') ?? "0" }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-center">Total Keseluruhan</th>
                        <th>{{ $total_keseluruhan }}</th>
                    </tr>
                </tfoot>
            </table>
            <br>
            {{-- {{ $perbarang->links() }} --}}
        </div>
    </div>
@endsection
