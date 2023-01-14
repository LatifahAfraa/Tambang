<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TujuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Tujuan';
        $data['tujuan'] = DB::table('tb_tujuan')->whereTujuanHapus(0)->get();
        return view('tujuan.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Tujuan';
        return view('tujuan.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
        ]);
        $insert = DB::table('tb_tujuan')
            ->insert([
                'tujuan_nama' => $request->nama,
            ]);
        if($insert)
        {
            return redirect()->route('tujuan.index')->with('success','Data berhasil ditambahkan');
        }
        else
        {
            return redirect()->route('tujuan.index')->with('error','Data gagal ditambahkan');
        }
    }

   
    public function edit($id)
    {
        $data['title'] = 'Tujuan';
        $data['tujuan'] = DB::table('tb_tujuan')->whereTujuanId($id)->first();
        return view('tujuan.edit',$data);
    }

    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'nama' => 'required',
        ]);
        $update = DB::table('tb_tujuan')
            ->whereTujuanId($id)
            ->update([
                'tujuan_nama' => $request->nama,
            ]);
        if($update)
        {
            return redirect()->route('tujuan.index')->with('success','Data berhasil diubah');
        }
        else
        {
            return redirect()->route('tujuan.index')->with('error','Data gagal diubah');
        }
    }

    public function destroy($id)
    {
        $delete = DB::table('tb_tujuan')
            ->whereTujuanId($id)
            ->update([
                'tujuan_hapus' => 1,
            ]);
        if($delete)
        {
            return back()->with('success','Data berhasil dihapus');
        }
        else
        {
            return back()->with('error','Data gagal dihapus');
        }
    }
}
