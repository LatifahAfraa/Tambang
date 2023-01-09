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
            Laporan Ritase Barang per Pelanggan<br>
            Dari {{ date("d F Y", $start) }} s/d {{ date("d F Y", $end) }}</h2>


        <table>
            <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Nama Pelanggan</th>
                        <th>Jumlah Ritase</th>
                        <th>Total</th>

                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                        $total_keseluruhan = 0;
                    @endphp
                    @foreach ($barang_perpelanggan as $barang => $member_lists)
                        @php
                            $total_barang = 0;
                            $members = [];
                        @endphp

                        @foreach ($member_lists as $key => $item)
                            @php
                                $members[] = [
                                    'nama' => $key,
                                    'qty' => $item->sum('qty') ?? 0
                                ];
                                $total_barang += $item->sum('qty') ?? 0;
                            @endphp
                        @endforeach
                        @php
                            $total_keseluruhan += $total_barang;
                        @endphp
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $barang ?? "" }}</td>
                            <td>{{ $members[0]['nama'] }}</td>
                            <td>{{ $members[0]['qty'] }}</td>
                            <td>{{ $total_barang ?? 0 }}</td>
                        </tr>



                        @foreach ($members as $key => $member)
                            @if ($key != 0)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>{{ $member['nama'] ?? "" }}</td>
                                    <td>{{ $member['qty'] ?? 0 }}</td>
                                    <td></td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                </tbody>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4">Total Keseluruhan</th>
                    <th>{{ $total_keseluruhan }}</th>
                </tr>
            </tfoot>
        </table>
       </center>
    </div>
</body>
</html>
