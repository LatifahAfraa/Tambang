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
        $tahun = $request->tahun ?? 2022;
        $data['tahun'] = $tahun;

        $data['perpelanggan'] = DB::table("tb_transaksi")
        ->select("tb_transaksi.*", "tb_member.member_nama")
        ->join('tb_member', 'tb_member.member_id', '=', 'tb_transaksi.member_id')
        ->whereBetween("tb_transaksi.check_in", [$tahun."-01-01", $tahun.'-12-16'])
        ->get()
        ->groupBy("member_nama");


        return view('laporan.perpelanggan',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cetak_perpelanggan(Request $request)
    {
        $tahun = $request->tahun ?? 2022;
        $data['tahun'] = $tahun;

        $data['perpelanggan'] = DB::table("tb_transaksi")
        ->select("tb_transaksi.*", "tb_member.member_nama")
        ->join('tb_member', 'tb_member.member_id', '=', 'tb_transaksi.member_id')
        ->whereBetween("tb_transaksi.check_in", [$tahun."-01-01", $tahun.'-12-16'])
        ->get()
        ->groupBy("member_nama");

        $pdf = PDF::loadview('laporan.cetak-perpelanggan',$data);
    	return $pdf->download('laporan-perpelanggan.pdf');
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
        $tahun = $request->tahun ?? 2022;
        $data['tahun'] = $tahun;

        $data['barang_perpelanggan'] = DB::table("tb_transaksi")
          ->select("tb_transaksi.*", "tb_member.member_nama", "tb_barang.barang_nama")
          ->join('tb_barang', 'tb_barang.barang_id', '=', 'tb_transaksi.barang_id')
          ->join('tb_member', 'tb_member.member_id', '=', 'tb_transaksi.member_id')
          ->whereBetween("tb_transaksi.check_in", [$tahun."-01-01", $tahun.'-12-16'])
          ->get()
          ->groupBy("barang_nama");

        return view('laporan.barang-perpelanggan',$data);

    }

    public function cetak_barang_perpelanggan(Request $request)
    {
        $tahun = $request->tahun ?? 2022;
        $data['tahun'] = $tahun;

        $data['barang_perpelanggan'] = DB::table("tb_transaksi")
          ->select("tb_transaksi.*", "tb_barang.barang_nama")
          ->join('tb_barang', 'tb_barang.barang_id', '=', 'tb_transaksi.barang_id')
          ->whereBetween("check_in", [$tahun."-01-01", $tahun.'-12-16'])
          ->get()
          ->groupBy("barang_nama");

        $pdf = PDF::loadview('laporan.cetak-barang-perpelanggan',$data);
    	return $pdf->download('laporan-barang-perpelanggan.pdf');
    }

    public function excel_barang_perpelanggan(Request $request)
    {
          return Excel::download(new BarangPerpelangganExport($request), 'laporan-barang-perpelanggan.xlsx');
    }

    public function perbarang(Request $request)
    {
        $data['title'] = 'Laporan Perbarang';
        $tahun = $request->tahun ?? 2022;
        $data['tahun'] = $tahun;


        $data['perbarang'] = DB::table('tb_transaksi')
            ->select("tb_transaksi.*", "tb_barang.barang_nama", "tb_satuan.satuan_nama")
            ->Join('tb_satuan', 'tb_satuan.satuan_id', '=', 'tb_transaksi.satuan_id')
            ->join('tb_barang', 'tb_barang.barang_id', '=', 'tb_transaksi.barang_id')
            ->whereBetween("check_in", [$tahun."-01-01", $tahun.'-12-16'])
            ->get()->groupBy(['barang_nama', 'satuan_nama']);

            return view('laporan.perbarang',$data);

    }

    public function cetak_perbarang(Request $request)
    {
        $tahun = $request->tahun ?? 2022;
        $data['tahun'] = $tahun;

        $data['perbarang'] = DB::table('tb_transaksi')
            ->select("tb_transaksi.*", "tb_barang.barang_nama", "tb_satuan.satuan_nama")
            ->Join('tb_satuan', 'tb_satuan.satuan_id', '=', 'tb_transaksi.satuan_id')
            ->join('tb_barang', 'tb_barang.barang_id', '=', 'tb_transaksi.barang_id')
            ->whereBetween("check_in", [$tahun."-01-01", $tahun.'-12-16'])
            ->get()->groupBy(['barang_nama', 'satuan_nama']);

        $pdf = PDF::loadview('laporan.cetak-perbarang',$data);
    	return $pdf->download('laporan-perbarang.pdf');
    }

    public function excel_perbarang(Request $request)
    {
          return Excel::download(new PerbarangExport($request), 'laporan-perbarang.xlsx');
    }

}
