<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index_op()
    {
        $data['title'] = 'Checkout';
        $data['transaksi'] = DB::table('tb_transaksi')
            ->select("tb_transaksi.*", "tb_member.member_nama", "tb_kendaraan.*", "tb_satuan.*", "tb_barang.*")
            ->join('tb_member','tb_transaksi.member_id','tb_member.member_id')
            ->leftJoin('tb_kendaraan','tb_transaksi.kendaraan_id','tb_kendaraan.kendaraan_id')
            ->leftJoin('tb_satuan','tb_transaksi.satuan_id','tb_satuan.satuan_id')
            ->leftJoin('tb_barang','tb_transaksi.barang_id','tb_barang.barang_id')
            ->orderBy('tb_transaksi.no_urut','asc')
            ->get();
            // return ($data['transaksi']);
        return view('checkout.index',$data);
    }

    public function status($id, $status)
    {
        $today = date('Y-m-d H:i:s');
        if($status == 1)
        {
            //DB::table('tb_transaksi')->where('transaksi_id', $id)->update(['status_transaksi' => $value, 'checkout' => $today]);
            DB::table('tb_transaksi')->whereTransaksiId($id)->update(['status_transaksi' => $status, 'check_out' => $today]);
            return back()->with('success','Berhasil Checkout');
        }
        if($status == 2)
        {
            DB::table('tb_transaksi')->whereTransaksiId($id)->update(['status_transaksi' => $status, 'check_out' => $today]);
            return redirect()->route('checkout.show', $id)->with('error','Checkout ditolak');
        }
    }

    public function show($id)
    {

        $data['title'] = 'Input Keterangan Penolakan';
        $data['transaksi'] = DB::table('tb_transaksi')
            ->whereTransaksiId($id)
            ->first();
        return view('checkout.create', $data);
    }

    public function ket(Request $request, $id)
    {
        $this->validate($request, [
            'keterangan' => 'required',
        ]);

        DB::table('tb_transaksi')->whereTransaksiId($id)->update(['keterangan' => $request->keterangan]);
        return redirect()->route('checkout.op')->with('error','Checkout ditolak');
    }

}
