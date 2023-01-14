<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class KendaraanController extends Controller
{
    //
    public function index()
    {
        $data['title'] = 'Kendaraan';
        $data['kendaraan'] = DB::table('tb_kendaraan')
            ->join('tb_member','tb_kendaraan.member_id','tb_member.member_id')
            ->whereKendaraanHapus(0)
            ->get();
        return view('kendaraan.index',$data);
    }

    public function create()
    {
        $data['title'] = 'Kendaraan';
        $data['member'] = DB::table('tb_member') 
        ->where(['member_hapus'=> 0 ])
        ->get();


        return view('kendaraan.create',$data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'member_id' => 'required',
            'no_pol' => 'required',
            'jenis' => 'required',
            'type' => 'required',
            'brand' => 'required',
            'kendaraan_foto'=>'required|file|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $file = $request->file('kendaraan_foto');
        $nama_file = time()."_".$file->getClientOriginalName();
        $tujuan_upload = 'storage/post-image';
		$file->move($tujuan_upload,$nama_file);
        
        
        $insert = DB::table('tb_kendaraan')
            ->insert([
                'member_id' => $request->member_id,
                'no_pol' => $request->no_pol,
                'jenis' => $request->jenis,
                'type' => $request->type,
                'brand' => $request->brand,
                'kendaraan_foto' =>$nama_file,
                
            ]);

        if($insert)
        {
            return redirect()->route('kendaraan.index')->with('success','Data berhasil ditambahkan');
        }
        else
        {
            return redirect()->route('kendaraan.create')->with('error','Data gagal ditambahkan');
        }
    }

    public function destroy($id)
    {
        $delete = DB::table('tb_kendaraan')
            ->whereKendaraanId($id)
            ->update([
                'kendaraan_hapus' => 1,
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
