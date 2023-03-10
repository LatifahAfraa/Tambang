<table id="" class="table table-bordered mt-2">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>Jumlah Ritase</th>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
            $total_keseluruhan = 0;
        @endphp
        {{-- fungsi => untuk ambil value  --}}
        @foreach ($perpelanggan as $tujuan_nama => $item)
            @php
                $total_keseluruhan += $item->sum('qty') ?? 0;
            @endphp
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $tujuan_nama }}</td>
                <td>{{ $item->sum('qty') ?? 0 }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2" class="text-center">Total Keseluruhan</th>
            <th>{{ $total_keseluruhan }}</th>
        </tr>
    </tfoot>
</table>
