@extends('master')
@section('title')
@section('content')

<div class="col-xl-12 col-lg-12 col-sm-12">
    <form method="get" action="" class="form-inline float-right">
        <div class="input-group">
            <input type="text" placeholder="Tahun" name="tahun" id="tahun" class="form-control input-daterange-datepicker" value="{{ request()->tahun ?? "" }}">
            <div class="input-group-prepend">
                <button type="submit" class="btn btn-outline-primary ">Telusuri</button>
            </div>
        </div>
    </form>
</div>
<br><br>

<div class="col-xl-12 col-lg-12 col-sm-12 mt-2">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Grafik Ritase</h4>
        </div>
        <div class="card-body">
            <canvas id="barChart_2"></canvas>
        </div>
    </div>
</div>

<div class="col-xl-12 col-lg-12 col-sm-12">
    <div class="card">
        <table id="" class="table table-bordered mt-2">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Bulan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp

                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $ms }}</td>
                        <td></td>
                    </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" class="text-center">Total Keseluruhan</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection
