<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GrafikController extends Controller
{
    public function index(Request $request)
    {
        $find = $request->tahun ?? date("01/01/2022 - 12/31/2022");

        $explode = explode("-", $find); //explode untuk memecah data waktu berdasarkan tanda -
        $start = Carbon::parse($explode[0])->format('Y-m-d') . ' 00:00:01';
        $data['start'] = $start;

        $end = Carbon::parse($explode[1])->format('Y-m-d') . ' 23:59:59';
        $data['end'] = $end;

        $tb_transaksi = DB::table("tb_transaksi")
        ->selectRaw("MONTH(check_in) as month, SUM(qty) as qty")
        ->whereBetween('check_in', [$start, $end])
        ->whereStatusTransaksi(1)
        ->groupByRaw('MONTH(check_in)')
        ->get();

        $data['transaksi'] = [];
        foreach ($tb_transaksi as $key => $transaksi) {
            $data['transaksi'][$transaksi->month] = $transaksi->qty;
        }


        $label_grafik = [];
        $data_grafik = [];
        for ($i=0; $i < 12; $i++) {
            $label_grafik[] = date('F', strtotime("2022-".($i+1)."-01"));
            $data_grafik[] = $data['transaksi'][$i+1] ?? 0;
        }

        return ['label' => $label_grafik, 'data' => $data_grafik];
    }
}
