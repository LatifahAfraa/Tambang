<?php

namespace App\Http\Controllers;
use DB;

class PointController extends Controller
{
    public function index()
    {
        # code...
        $data['title'] = 'Point Sopir';

        $data['point_sopir'] = DB::table("tb_member")->get();


        return view('point.point-sopir',$data);
    }
}
