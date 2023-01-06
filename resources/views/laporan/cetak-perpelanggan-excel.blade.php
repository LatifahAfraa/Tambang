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
            $no = ((request()->has('page') && request()->get('page') > 1 ? request()->get('page') : 1) - 1) * 10 + 1;
            $total_keseluruhan = 0;
        @endphp
        {{-- fungsi => untuk ambil value  --}}
        @foreach ($perpelanggan as $member_nama => $item)
            @php
                $total_keseluruhan += $item->sum('qty') ?? 0;
            @endphp
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $member_nama }}</td>
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
