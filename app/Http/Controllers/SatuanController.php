<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SatuanController extends Controller
{
    //
    public function index()
    {
        $data['title'] = 'Satuan';
        $data['satuan'] = DB::table('tb_satuan')->whereSatuanHapus(0)->get();
        return view('satuan.index',$data);
    }

    public function create()
    {
        $data['title'] = 'Satuan';
        return view('satuan.create',$data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
        ]);
        $insert = DB::table('tb_satuan')
            ->insert([
                'satuan_nama' => $request->nama,
            ]);
        if($insert)
        {
            return redirect()->route('satuan.index')->with('success','Data berhasil ditambahkan');
        }
        else
        {
            return redirect()->route('satuan.index')->with('error','Data gagal ditambahkan');
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Satuan';
        $data['satuan'] = DB::table('tb_satuan')->wheresatuanId($id)->first();
        return view('satuan.edit',$data);
    }

    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'nama' => 'required',
        ]);
        $update = DB::table('tb_satuan')
            ->wheresatuanId($id)
            ->update([
                'satuan_nama' => $request->nama,
            ]);
        if($update)
        {
            return redirect()->route('satuan.index')->with('success','Data berhasil diubah');
        }
        else
        {
            return redirect()->route('satuan.index')->with('error','Data gagal diubah');
        }
    }

    public function destroy($id)
    {
        $delete = DB::table('tb_satuan')
            ->wheresatuanId($id)
            ->update([
                'satuan_hapus' => 1,
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
