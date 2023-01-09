<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        table,
        td,
        th {
            border: 1px solid;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
    </style>
    <title>Document</title>
</head>

<body>
    <div class="container-fluid">
        <center>
            <h2> Koppaska (Koperasi Jasa Pengusaha Pasir Silika)<br>
                Laporan Ritase per Barang<br>
                Dari {{ date("d F Y", $start) }} s/d {{ date("d F Y", $end) }}</h2>


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
                        <th colspan="3">Total Keseluruhan</th>
                        <th>{{ $total_keseluruhan }}</th>
                    </tr>
                </tfoot>
            </table>
        </center>
    </div>
</body>

</html>
