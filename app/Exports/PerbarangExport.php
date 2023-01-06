<?php

namespace App\Exports;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class PerbarangExport implements FromView
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $tahun = $this->request->tahun ?? 2022;
        $data['tahun'] = $tahun;

        $data['perbarang'] = DB::table('tb_transaksi')
            ->select("tb_transaksi.*", "tb_barang.barang_nama", "tb_satuan.satuan_nama")
            ->Join('tb_satuan', 'tb_satuan.satuan_id', '=', 'tb_transaksi.satuan_id')
            ->join('tb_barang', 'tb_barang.barang_id', '=', 'tb_transaksi.barang_id')
            ->whereBetween("check_in", [$tahun."-01-01", $tahun.'-12-16'])
            ->get()->groupBy(['barang_nama', 'satuan_nama']);
        return view('laporan.cetak-perbarang-excel', $data);
    }
}
