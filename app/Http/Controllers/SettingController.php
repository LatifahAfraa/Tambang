<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    //
    public function index()
    {
        $data['title'] = 'Setting';
        $data['maps'] = \DB::table('setting')->first();
        return view('setting.index',$data);
    }

    public function update($opt, Request $request)
    {
        if($opt == 'maps')
        {
            \DB::table('setting')->update(['latitude' => $request->latitude, 'longitude' => $request->longitude]);
        }
        return back()->with('success','Data berhasil diubah ! ! !');
    }
}
