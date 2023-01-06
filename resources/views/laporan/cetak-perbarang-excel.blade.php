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
            $no = ((((request()->has('page') && request()->get('page') > 1)? request()->get('page') : 1)-1) *10) + 1;
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
