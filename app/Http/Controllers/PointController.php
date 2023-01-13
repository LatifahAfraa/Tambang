<?php

namespace App\Http\Controllers;
use DB;

class PointController extends Controller
{
    public function index()
    {
        # code...
        $data['title'] = 'Point Sopir';

        $data['members'] = DB::table("tb_member")
        ->select('tb_member.*')
        ->selectRaw('(SELECT SUM(log_point.jumlah) FROM log_point WHERE log_point.member_id=tb_member.member_id) as jumlah_point')
        ->whereMemberHapus(0)
        ->get();

        // dd($data['members']);

        return view('point.point-sopir',$data);
    }
}
