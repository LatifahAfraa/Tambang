<table class="table table-bordered mt-2">
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
            $no = ((((request()->has('page') && request()->get('page') > 1)? request()->get('page') : 1)-1) *10) + 1;
            $total_keseluruhan = 0;
        @endphp
        @foreach ($barang_perpelanggan as $items)

            @php
                $total_keseluruhan += $items->sum('qty');
            @endphp
            <tr>
                <td rowspan="{{ $items->count() }}">{{ $no++ }}</td>
                <td rowspan="{{ $items->count() }}">{{ $items->get(0)->barang_nama ?? "" }}</td>
                <td>{{ $items->get(0)->member_nama ?? "" }}</td>
                <td>{{ $items->get(0)->qty ?? 0 }}</td>
                <td rowspan="{{ $items->count() }}">{{ $items->sum('qty') }}</td>
            </tr>
            @foreach ($items as $key => $item)
                @if ($key > 0)
                    <tr>
                        <td>{{ $item->member_nama ?? "" }}</td>
                        <td>{{ $item->qty ?? 0 }}</td>
                    </tr>
                @endif
            @endforeach
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="4">Total Keseluruhan</th>
            <th>{{ $total_keseluruhan }}</th>
        </tr>
    </tfoot>
</table>
