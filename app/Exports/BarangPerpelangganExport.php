<?php

namespace App\Exports;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class BarangPerpelangganExport implements FromView
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

        $data['barang_perpelanggan'] = DB::table("tb_transaksi")
          ->select("tb_transaksi.*", "tb_member.member_nama", "tb_barang.barang_nama")
          ->join('tb_barang', 'tb_barang.barang_id', '=', 'tb_transaksi.barang_id')
          ->join('tb_member', 'tb_member.member_id', '=', 'tb_transaksi.member_id')
          ->whereBetween("tb_transaksi.check_in", [$tahun."-01-01", $tahun.'-12-16'])
          ->get()
          ->groupBy("barang_nama");
        return view('laporan.cetak-barang-perpelanggan-excel', $data);
    }
}
