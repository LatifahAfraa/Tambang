<?php

namespace App\Exports;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class PerpelangganExport implements FromView
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

        $data['perpelanggan'] = DB::table("tb_transaksi")
        ->select("tb_transaksi.*", "tb_member.member_nama")
        ->join('tb_member', 'tb_member.member_id', '=', 'tb_transaksi.member_id')
        ->whereBetween("tb_transaksi.check_in", [$tahun."-01-01", $tahun.'-12-16'])
        ->get()
        ->groupBy("member_nama");
        return view('laporan.cetak-perpelanggan-excel', $data);
    }
}
