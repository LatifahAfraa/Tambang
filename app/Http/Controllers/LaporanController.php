<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use App\Models\MemberModel;
use Illuminate\Http\Request;
use App\Exports\PerbarangExport;
use App\Exports\PerpelangganExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BarangPerpelangganExport;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data['title'] = 'Laporan Perpelanggan';
        $find = $request->tahun ?? date("m/d/Y - m/d/Y");

        $explode = explode("-", $find); //explode untuk memecah data waktu berdasarkan tanda -
        $start = trim($explode[0]); //trim untuk menghilangkan spasi pada data waktu explode [0] untuk mengambil array pertama
        $end = trim($explode[1]);

        $start = strtotime($start); // format date m/d/Y (01/01/2022) menjadi time : (1640970000)
        $data['start'] = $start;
        $start = date("Y-m-d", $start); // ubah time: 1640970000  menjadi date Y-m-d (2022-01-01)

        $end = strtotime($end);
        $data['end'] = $end;
        $end = date('Y-m-d', $end);

        // 2022-01-01 00:00:00
        // 2022-12-16 00:00:00
        // 2022-12-16 23:59:59



        $data['perpelanggan'] = DB::table("tb_transaksi")
        ->select("tb_transaksi.*", "tb_tujuan.tujuan_nama")
        ->join('tb_tujuan', 'tb_tujuan.tujuan_id', '=', 'tb_transaksi.tujuan_id')
        ->whereBetween("tb_transaksi.check_in", [$start, $end.' 23:59:59'])
        // ->whereBetween("tb_transaksi.check_in", [$start, $end])
        ->whereStatusTransaksi(1)
        ->get()
        ->groupBy("tujuan_nama");


        return view('laporan.perpelanggan',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cetak_perpelanggan(Request $request)
    {

        $find = $request->tahun ?? date("m/d/Y - m/d/Y");

        $explode = explode("-", $find); //explode untuk memecah data waktu berdasarkan tanda -
        $start = trim($explode[0]); //trim untuk menghilangkan spasi pada data waktu explode [0] untuk mengambil array pertama
        $end = trim($explode[1]);

        $start = strtotime($start); // format date m/d/Y (01/01/2022) menjadi time : (1640970000)
        $data['start'] = $start;
        $start = date("Y-m-d", $start); // ubah time: 1640970000  menjadi date Y-m-d (2022-01-01)

        $end = strtotime($end);
        $data['end'] = $end;
        $end = date('Y-m-d', $end);

        // 2022-01-01 00:00:00
        // 2022-12-16 00:00:00
        // 2022-12-16 23:59:59



        $data['perpelanggan'] = DB::table("tb_transaksi")
        ->select("tb_transaksi.*", "tb_tujuan.tujuan_nama")
        ->join('tb_tujuan', 'tb_tujuan.tujuan_id', '=', 'tb_transaksi.tujuan_id')
        ->whereBetween("tb_transaksi.check_in", [$start, $end.' 23:59:59'])
        // ->whereBetween("tb_transaksi.check_in", [$start, $end])
        ->whereStatusTransaksi(1)
        ->get()
        ->groupBy("tujuan_nama");


        // $pdf = PDF::loadview('laporan.cetak-perpelanggan', $data);
    	// return $pdf->download('laporan-perpelanggan.pdf', $data);
        $pdf = PDF::loadview('laporan.cetak-perpelanggan', $data);
    	return $pdf->stream('laporan-perpelanggan.pdf', $data);
    }

    public function excel_perpelanggan(Request $request)
    {
          return Excel::download(new PerpelangganExport($request), 'laporan-perpelanggan.xlsx');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function barang_perpelanggan(Request $request)
    {
        $data['title'] = 'Laporan Barang Perpelanggan';
        $find = $request->tahun ?? date("m/d/Y - m/d/Y");

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
          ->select("tb_transaksi.*", "tb_tujuan.tujuan_nama", "tb_barang.barang_nama")
          ->join('tb_barang', 'tb_barang.barang_id', '=', 'tb_transaksi.barang_id')
          ->join('tb_tujuan', 'tb_tujuan.tujuan_id', '=', 'tb_transaksi.tujuan_id')
          ->whereBetween("tb_transaksi.check_in", [$start, $end.' 23:59:59'])
          ->whereStatusTransaksi(1)
          ->get()
          ->groupBy(['barang_nama', 'tujuan_nama']);


        return view('laporan.barang-perpelanggan',$data);

    }

    public function cetak_barang_perpelanggan(Request $request)
    {
        $find = $request->tahun ?? date("m/d/Y - m/d/Y");

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
          ->select("tb_transaksi.*", "tb_tujuan.tujuan_nama", "tb_barang.barang_nama")
          ->join('tb_barang', 'tb_barang.barang_id', '=', 'tb_transaksi.barang_id')
          ->join('tb_tujuan', 'tb_tujuan.tujuan_id', '=', 'tb_transaksi.tujuan_id')
          ->whereBetween("tb_transaksi.check_in", [$start, $end.' 23:59:59'])
          ->whereStatusTransaksi(1)
          ->get()
          ->groupBy(['barang_nama', 'tujuan_nama']);

        $pdf = PDF::loadview('laporan.cetak-barang-perpelanggan',$data);
    	return $pdf->stream('laporan-barang-perpelanggan.pdf');
    }

    public function excel_barang_perpelanggan(Request $request)
    {
          return Excel::download(new BarangPerpelangganExport($request), 'laporan-barang-perpelanggan.xlsx');
    }

    public function perbarang(Request $request)
    {
        $data['title'] = 'Laporan Perbarang';
        $find = $request->tahun ?? date("m/d/Y - m/d/Y");

        $explode = explode("-", $find); //explode untuk memecah data waktu berdasarkan tanda -
        $start = trim($explode[0]); //trim untuk menghilangkan spasi pada data waktu explode [0] untuk mengambil array pertama
        $end = trim($explode[1]);

        $start = strtotime($start); // format date m/d/Y (01/01/2022) menjadi time : (1640970000)
        $data['start'] = $start;
        $start = date("Y-m-d", $start); // ubah time: 1640970000  menjadi date Y-m-d (2022-01-01)

        $end = strtotime($end);
        $data['end'] = $end;
        $end = date('Y-m-d', $end);


        $data['perbarang'] = DB::table('tb_transaksi')
            ->select("tb_transaksi.*", "tb_barang.barang_nama", "tb_satuan.satuan_nama", "tb_tujuan.tujuan_nama")
            ->Join('tb_satuan', 'tb_satuan.satuan_id', '=', 'tb_transaksi.satuan_id')
            ->join('tb_barang', 'tb_barang.barang_id', '=', 'tb_transaksi.barang_id')
            ->join('tb_tujuan', 'tb_tujuan.tujuan_id', '=', 'tb_transaksi.tujuan_id')
            ->whereBetween("check_in", [$start, $end.' 23:59:59'])
            ->whereStatusTransaksi(1)
            ->get()->groupBy(['barang_nama', 'satuan_nama']);

            return view('laporan.perbarang',$data);

    }

    public function cetak_perbarang(Request $request)
    {
        $find = $request->tahun ?? date("m/d/Y - m/d/Y");

        $explode = explode("-", $find); //explode untuk memecah data waktu berdasarkan tanda -
        $start = trim($explode[0]); //trim untuk menghilangkan spasi pada data waktu explode [0] untuk mengambil array pertama
        $end = trim($explode[1]);

        $start = strtotime($start); // format date m/d/Y (01/01/2022) menjadi time : (1640970000)
        $data['start'] = $start;
        $start = date("Y-m-d", $start); // ubah time: 1640970000  menjadi date Y-m-d (2022-01-01)

        $end = strtotime($end);
        $data['end'] = $end;
        $end = date('Y-m-d', $end);

        $data['perbarang'] = DB::table('tb_transaksi')
        ->select("tb_transaksi.*", "tb_barang.barang_nama", "tb_satuan.satuan_nama", "tb_tujuan.tujuan_nama")
        ->Join('tb_satuan', 'tb_satuan.satuan_id', '=', 'tb_transaksi.satuan_id')
        ->join('tb_barang', 'tb_barang.barang_id', '=', 'tb_transaksi.barang_id')
        ->join('tb_tujuan', 'tb_tujuan.tujuan_id', '=', 'tb_transaksi.tujuan_id')
        ->whereBetween("check_in", [$start, $end.' 23:59:59'])
        ->whereStatusTransaksi(1)
        ->get()->groupBy(['barang_nama', 'satuan_nama']);

        $pdf = PDF::loadview('laporan.cetak-perbarang',$data);
    	return $pdf->stream('laporan-perbarang.pdf', $data);
    }

    public function excel_perbarang(Request $request)
    {
          return Excel::download(new PerbarangExport($request), 'laporan-perbarang.xlsx');
    }

}
