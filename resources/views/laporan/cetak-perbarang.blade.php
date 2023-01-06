<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        table,td,th {
            border: 1px solid;
        }

        table{
            width: 100%;
            border-collapse: collapse;
        }
    </style>
    <title>Document</title>
</head>
<body>
    <div class="container-fluid">
       <center> <h2> Koppaska (Koperasi Jasa Pengusaha Pasir Silika)<br>
            Laporan Ritase per Barang<br>
            Dari 01 Januari {{ $tahun }} s/d 16 Desember {{ $tahun }}</h2>


        <table>
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
                $no = ((((request()->has('page') && request()->get('page') > 1)? request()->get('page') : 1)-1) *10) + 1;
                $total_keseluruhan = 0;
            @endphp
            @foreach ($perbarang as $item )
                @php
                    $total_keseluruhan += $item->total_transaksi;
                @endphp
                <tr>
                    @if ($item->barang_id == $item->satuan_id)

                    <td>{{ $no++ }}</td>
                    <td>{{ $item->barang_nama }}</td>
                    <td>{{ $item->satuan_nama }}</td>
                    <td>{{ $item->total_transaksi }}</td>
                    @endif
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Keseluruhan</th>
                    <th>{{ $total_keseluruhan }}</th>
                </tr>
            </tfoot>
        </table>
       </center>
    </div>
</body>
</html>
