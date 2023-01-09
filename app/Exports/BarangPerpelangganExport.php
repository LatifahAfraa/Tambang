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
        $find = $this->request->tahun ?? date("m/d/Y - m/d/Y");

        $explode = explode("-", $find); //explode untuk memecah data waktu berdasarkan tanda -
        $start = trim($explode[0]); //trim untuk menghilangkan spasi pada data waktu explode [0] untuk mengambil array pertama
        $end = trim($explode[1]);

        $start = strtotime($start); // format date m/d/Y (01/01/2022) menjadi time : (1640970000)
        $data['start'] = $start;
        $start = date("Y-m-d", $start); // ubah time: 1640970000  menjadi date Y-m-d (2022-01-01)

        $end = strtotime($end);
        $data['end'] = $end;
        $end = date('Y-m-d', $end);

        $data['barang_perpelanggan'] = DB::table("tb_transaksi")
          ->select("tb_transaksi.*", "tb_member.member_nama", "tb_barang.barang_nama")
          ->join('tb_barang', 'tb_barang.barang_id', '=', 'tb_transaksi.barang_id')
          ->join('tb_member', 'tb_member.member_id', '=', 'tb_transaksi.member_id')
          ->whereBetween("tb_transaksi.check_in", [$start, $end.' 23:59:59'])
          ->get()
          ->groupBy(['barang_nama', 'member_nama']);

        return view('laporan.cetak-barang-perpelanggan-excel', $data);
    }
}
