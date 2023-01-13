@extends('master')
@section('title')
@section('content')

<div class="mb-5">
    <center>
        <h2> Koppaska (Koperasi Jasa Pengusaha Pasir Silika)<br>
            Grafik Ritase<br>
            Dari {{ date("d F Y",strtotime( $start))}} s/d {{ date("d F Y", strtotime( $end)) }}
        </h2>
    </center>
</div>

<div class="col-xl-12 col-lg-12 col-sm-12">
    <form method="get" action="" class="form-inline float-right">
        <div class="input-group">
            <input type="text" placeholder="Tahun" name="tahun" id="tahun" class="form-control input-daterange-datepicker" value="{{ request()->tahun ?? date("01/01/2022 - 12/31/2022") }}">
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
            <canvas id="grafik_ritase"></canvas>
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
                    $total_keseluruhan = 0;
                @endphp

                    @for ($i = 0; $i < 12; $i++)
                        @php
                            $total_keseluruhan += $transaksi[$i+1] ?? 0;
                        @endphp
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ date('F', strtotime("2022-".($i+1)."-01")) }}</td>
                            <td>{{ $transaksi[$i+1] ?? 0 }}</td>
                        </tr>
                    @endfor
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" class="text-center">Total Keseluruhan</th>
                    <th>{{ $total_keseluruhan }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@endsection
@push('js')
    <script>
        var barChart2 = function(){
            if(jQuery('#grafik_ritase').length > 0 ){

            //gradient bar chart
                const grafik_ritase = document.getElementById("grafik_ritase").getContext('2d');
                //generate gradient
                const grafik_ritasegradientStroke = grafik_ritase.createLinearGradient(0, 0, 0, 250);
                grafik_ritasegradientStroke.addColorStop(0, "rgba(34, 47, 185, 1)");
                grafik_ritasegradientStroke.addColorStop(1, "rgba(34, 47, 185, 0.5)");

                grafik_ritase.height = 100;

                $.get("{{ route('grafik', ['tahun' => request()->tahun ?? date('01/01/2022 - 12/31/2022') ]) }}", (result) => {
                    new Chart(grafik_ritase, {
                        type: 'bar',
                        data: {
                            defaultFontFamily: 'Poppins',
                            labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
                            datasets: [
                                {
                                    label: "My First dataset",
                                    data: result.data,
                                    borderColor: grafik_ritasegradientStroke,
                                    borderWidth: "0",
                                    backgroundColor: grafik_ritasegradientStroke,
                                    hoverBackgroundColor: grafik_ritasegradientStroke
                                }
                            ]
                        },
                        options: {
                            legend: false,
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }],
                                xAxes: [{
                                    // Change here
                                    barPercentage: 0.5
                                }]
                            }
                        }
                    });
                })
            }
        }

        $(document).ready(() => {
            barChart2()
        })
    </script>
@endpush
