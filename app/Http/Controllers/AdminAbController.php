<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAbController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Checkin';
        $today = date('Y-m-d');
        $data['transaksi'] = DB::table('tb_transaksi')
            ->join('tb_member','tb_transaksi.member_id','tb_member.member_id')
            ->leftJoin('tb_kendaraan','tb_transaksi.kendaraan_id','tb_kendaraan.kendaraan_id')
            ->leftJoin('tb_satuan','tb_transaksi.satuan_id','tb_satuan.satuan_id')
            ->leftJoin('tb_barang','tb_transaksi.barang_id','tb_barang.barang_id')
            ->leftJoin('tb_tujuan','tb_transaksi.tujuan_id','tb_tujuan.tujuan_id')
            ->whereDate('tb_transaksi.check_in',$today)
            ->where(['status_transaksi'=> 0])
            ->orderBy('tb_transaksi.no_urut','asc')
            ->get();
        return view('adminAb.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Checkin';
        $data['member'] = DB::table('tb_member')
        ->where(['member_hapus' => 0])
        ->get();

        $data['kendaraan'] = DB::table('tb_kendaraan')
        ->join('tb_member','tb_kendaraan.member_id','tb_member.member_id')
        ->get();
        return view('adminAb.create',$data);
    }

    public function select_member(Request $request)
    {
        $member=[];

        if ($request->has('q')) {
            $search = $request->q;
            $member = DB::table('tb_member')
                ->select('member_id', 'member_nama')
                ->Where('member_nama', 'LIKE', "%$search%")
                ->get();
        } else {
            $member = DB::table('tb_member')->limit(10)->get();
        }
        return response()->json($member);
    }

    public function select_kendaraan(Request $request)
    {
        $kendaraan = [];
        $memberId = $request->memberId;
        if ($request->has('q')) {
            $search = $request->q;
            $kendaraan = DB::table('tb_kendaraan')->select('kendaraan_id','no_pol')
                ->where('member_id', $memberId)
                ->Where('no_pol', 'LIKE', "%$search%")
                ->get();
        } else {
            $kendaraan = DB::table('tb_kendaraan')
            ->where('member_id', $memberId)->limit(10)->get();
        }
        return response()->json($kendaraan);
    }


    public function store(Request $request)
    {
        $today = date('Y-m-d');
        $nomor = \DB::table('tb_transaksi')->whereDate('check_in',$today)->orderBy('no_urut','desc')->first();
        if($nomor)
        {
            $no = $nomor->no_urut;
            $no = (int)$no+1;
        } else {
            $no = 1;
        }
        $this->validate($request, [
            'member_id' => 'required',
            'kendaraan_id' => 'required',
        ]);
        $insert = DB::table('tb_transaksi')
                    ->insert([
                                'member_id' => $request->member_id,
                                'kendaraan_id' => $request->kendaraan_id,
                                'latitude' => $request->lat,
                                'longitude' => $request->long,
                                'no_urut' => $no,
            ]);
        if($insert)
        {
            return redirect()->route('adminAb.index')->with('success','Berhasil ambil absen');
        }
        else
        {
            return redirect()->route('adminAb.index')->with('error','Gagal mengambil absen');
        }
    }




    //op2

    public function index_op2()
    {
        $data['title'] = 'Checkin';
        $today = date('Y-m-d');
        $data['transaksi'] = DB::table('tb_transaksi')
            ->join('tb_member','tb_transaksi.member_id','tb_member.member_id')
            ->leftJoin('tb_kendaraan','tb_transaksi.kendaraan_id','tb_kendaraan.kendaraan_id')
            ->leftJoin('tb_satuan','tb_transaksi.satuan_id','tb_satuan.satuan_id')
            ->leftJoin('tb_barang','tb_transaksi.barang_id','tb_barang.barang_id')
            ->leftJoin('tb_tujuan','tb_transaksi.tujuan_id','tb_tujuan.tujuan_id')
            ->whereDate('tb_transaksi.check_in',$today)
            ->where(['status_transaksi'=> 0])
            ->orderBy('tb_transaksi.no_urut','asc')
            ->get();
        return view('adminAb.operator2.index',$data);
    }

    public function create_op2()
    {
        $data['title'] = 'Checkin';
        $data['member'] = DB::table('tb_member')
        ->where(['member_hapus' => 0])
        ->get();
        $data['kendaraan'] = DB::table('tb_kendaraan')
        ->get();
        return view('adminAb.operator2.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_op2(Request $request)
    {
        $today = date('Y-m-d');
        $nomor = \DB::table('tb_transaksi')->whereDate('check_in',$today)->orderBy('no_urut','desc')->first();
        if($nomor)
        {
            $no = $nomor->no_urut;
            $no = (int)$no+1;
        } else {
            $no = 1;
        }
        $this->validate($request, [
            'member_id' => 'required',
            'kendaraan_id' => 'required',
        ]);
        $insert = DB::table('tb_transaksi')
                    ->insert([
                                'member_id' => $request->member_id,
                                'kendaraan_id' => $request->kendaraan_id,
                                'latitude' => $request->lat,
                                'longitude' => $request->long,
                                'no_urut' => $no,
            ]);
        if($insert)
        {
            return redirect()->route('adminAb.index.op2')->with('success','Berhasil ambil absen');
        }
        else
        {
            return redirect()->route('adminAb.index.op2')->with('error','Gagal mengambil absen');
        }
    }

}
