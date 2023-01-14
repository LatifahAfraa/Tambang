<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class BarangController extends Controller
{
    //
    public function index()
    {
        $data['title'] = 'Barang';
        $data['barang'] = DB::table('tb_barang')->whereBarangHapus(0)->get();
        return view('barang.index',$data);
    }

    public function create()
    {
            $data['title'] = 'Barang';
            return view('barang.create',$data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
        ]);
        $insert = DB::table('tb_barang')
            ->insert([
                'barang_nama' => $request->nama,
            ]);
        if($insert)
        {
            return redirect()->route('barang.index')->with('success','Data berhasil ditambahkan');
        }
        else
        {
            return redirect()->route('barang.index')->with('error','Data gagal ditambahkan');
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Barang';
        $data['barang'] = DB::table('tb_barang')->whereBarangId($id)->first();
        return view('barang.edit',$data);
    }

    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'nama' => 'required',
        ]);
        $update = DB::table('tb_barang')
            ->whereBarangId($id)
            ->update([
                'barang_nama' => $request->nama,
            ]);
        if($update)
        {
            return redirect()->route('barang.index')->with('success','Data berhasil diubah');
        }
        else
        {
            return redirect()->route('barang.index')->with('error','Data gagal diubah');
        }
    }

    public function destroy($id)
    {
        $delete = DB::table('tb_barang')
            ->whereBarangId($id)
            ->update([
                'barang_hapus' => 1,
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
