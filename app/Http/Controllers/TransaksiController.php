<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Image;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    //
    public function index()
    {
        $data['title'] = 'Transaksi';
        $today = date('Y-m-d');
        $data['transaksi'] = DB::table('tb_transaksi')
            ->join('tb_member','tb_transaksi.member_id','tb_member.member_id')
            ->leftJoin('tb_kendaraan','tb_transaksi.kendaraan_id','tb_kendaraan.kendaraan_id')
            ->leftJoin('tb_satuan','tb_transaksi.satuan_id','tb_satuan.satuan_id')
            ->leftJoin('tb_barang','tb_transaksi.barang_id','tb_barang.barang_id')
            ->leftJoin('tb_tujuan','tb_transaksi.tujuan_id','tb_tujuan.tujuan_id')
            ->whereDate('tb_transaksi.check_in',$today)
            ->orderBy('tb_transaksi.no_urut','asc')
            ->get();
        return view('transaksi.index',$data);
    }

    public function edit($id)
    {
        $data['title'] = 'Input Detail Check-In';
        $data['transaksi'] = DB::table('tb_transaksi')
            ->join('tb_member','tb_transaksi.member_id','tb_member.member_id')
            ->whereTransaksiId($id)
            ->first();
        $data['kendaraan'] = DB::table('tb_kendaraan')->whereMemberId($data['transaksi']->member_id)->whereKendaraanHapus(0)->get();
        return view('transaksi.edit',$data);
    }

    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'kendaraan' => 'required',
        ]);
        $update = DB::table('tb_transaksi')->whereTransaksiId($id)->update(['kendaraan_id' => $request->kendaraan]);
        if($update)
        {
            return redirect()->route('transaksi.index')->with('success','Berhasil Melengkapi Data');
        }
        else
        {
            return back()->with('error','Gagal Melengkapi Data');
        }
    }

    public function complete($id)
    {
        $data['title'] = 'Input Detail Check-In';
        $data['transaksi'] = DB::table('tb_transaksi')
            ->join('tb_member','tb_transaksi.member_id','tb_member.member_id')
            ->whereTransaksiId($id)
            ->first();
        $data['kendaraan'] = DB::table('tb_kendaraan')->whereMemberId($data['transaksi']->member_id)->whereKendaraanHapus(0)->get();
        $data['barang'] = DB::table('tb_barang')->whereBarangHapus(0)->get();
        $data['satuan'] = DB::table('tb_satuan')->whereSatuanHapus(0)->get();
        $data['tujuan'] = DB::table('tb_tujuan')->whereTujuanHapus(0)->get();
        return view('transaksi.complete',$data);
    }

    public function completeTransaksi(Request $request,$id)
    {
        $this->validate($request, [
            'kendaraan' => 'required',
            'barang' => 'required',
            'satuan' => 'required',
            'status' => 'required',
            'tujuan' => 'required',
            'qty' => 'required',
            'foto' => 'mimes:jpg,jpeg,bmp,png',
        ]);
        $data = DB::table('tb_transaksi')->whereTransaksiId($id)->first();
        $member = DB::table('tb_member')->whereMemberId($data->member_id)->first();
        if($request->status == 1)
        {
            DB::table('tb_member')->whereMemberId($member->member_id)->update(['point' => $member->point + 1]);
        }

        if($request->foto)
        {
            @unlink('bukti/'.$data->foto_barang);
            $thumbnailImage = Image::make($request->foto);
            $thumbnailPath = 'bukti/';
            $thumbnailImage->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $filename = str_replace(' ', '', time() . $request->foto->getClientOriginalName());
            $thumbnailImage->save($thumbnailPath . $filename);
        }
        else
        {
            $filename = $data->foto_barang;
        }
        $update = DB::table('tb_transaksi')
            ->whereTransaksiId($id)
            ->update([
                'kendaraan_id' => $request->kendaraan,
                'barang_id' => $request->barang,
                'satuan_id' => $request->satuan,
                'tujuan_id' => $request->tujuan,
                'qty' => $request->qty,
                'foto_barang' => $filename,
                'status_transaksi' => $request->status,
                'check_out' => Carbon::now()
            ]);
        if($update)
        {
            if($request->status == 1)
            {
                \DB::table('log_point')
                ->insert([
                    'member_id' => $member->member_id,
                    'jumlah' => 1,
                    'type' => 'Plus',
                    'keterangan' => 'Sukses transaksi pada Tanggal : '.Carbon::now(). 'No Urut : '.$data->no_urut,
                ]);
            }
            return redirect()->route('transaksi.index')->with('success','Berhasil Melengkapi Data');
        }
        else
        {
            return back()->with('error','Gagal Melengkapi Data');
        }
    }

    public function status($id,$value)
    {
        DB::table('tb_transaksi')->whereTransaksiId($id)->update(['status_transaksi' => $value]);
        if($value == 1)
        {
            return back()->with('success','Transaksi telah diterima.');
        }
        else
        {
            return back()->with('error','Transaksi ditolak.');
        }
    }

    public function cek($id)
    {
        $data['title'] = 'Pengecekan Kembali';
        $data['transaksi'] = DB::table('tb_transaksi')
            ->join('tb_member','tb_transaksi.member_id','tb_member.member_id','tb_tujuan.tujuan_id')
            ->whereTransaksiId($id)
            ->first();
        $data['kendaraan'] = DB::table('tb_kendaraan')->whereMemberId($data['transaksi']->member_id)->whereKendaraanHapus(0)->get();
        $data['barang'] = DB::table('tb_barang')->whereBarangHapus(0)->get();
        $data['satuan'] = DB::table('tb_satuan')->whereSatuanHapus(0)->get();
        $data['tujuan'] = DB::table('tb_tujuan')->whereTujuanHapus(0)->get();
        return view('transaksi.cek',$data);
    }

    public function ceks(Request $request,$id)
    {
        $this->validate($request, [
            'foto' => 'mimes:jpg,jpeg,bmp,png',
        ]);
        $data = DB::table('tb_transaksi')->whereTransaksiId($id)->first();
        $member = DB::table('tb_member')->whereMemberId($data->member_id)->first();
        if($data->status_transaksi != 1)
        {
            if($request->status == 1)
            {
                DB::table('tb_member')->whereMemberId($member->member_id)->update(['point' => $member->point + 1]);
            }
        }
        else
        {
            if($request->status == 2)
            {
                DB::table('tb_member')->whereMemberId($member->member_id)->update(['point' => $member->point - 1]);
            }
        }

        if($request->foto)
        {
            @unlink('bukti/'.$data->foto_barang);
            $thumbnailImage = Image::make($request->foto);
            $thumbnailPath = 'bukti/';
            $thumbnailImage->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $filename = str_replace(' ', '', time() . $request->foto->getClientOriginalName());
            $thumbnailImage->save($thumbnailPath . $filename);
        }
        else
        {
            $filename = $data->foto_barang;
        }
        $update = DB::table('tb_transaksi')
            ->whereTransaksiId($id)
            ->update([
                'kendaraan_id' => $request->kendaraan,
                'barang_id' => $request->barang,
                'tujuan_id' => $request->tujuan,
                'satuan_id' => $request->satuan,
                'qty' => $request->qty,
                'foto_barang' => $filename,
                'status_transaksi' => $request->status
            ]);
        if($update)
        {
            if($request->status == 1)
            {
                \DB::table('log_point')
                ->insert([
                    'member_id' => $member->member_id,
                    'jumlah' => 1,
                    'type' => 'Plus',
                    'keterangan' => 'Pengecekan kembali transaksi pada Tanggal : '.Carbon::now(). 'No Urut : '.$data->no_urut,
                ]);
            }
            else
            {
                \DB::table('log_point')
                ->insert([
                    'member_id' => $member->member_id,
                    'jumlah' => 1,
                    'type' => 'Minus',
                    'keterangan' => 'Pengecekan kembali transaksi pada Tanggal : '.Carbon::now(). 'No Urut : '.$data->no_urut,
                ]);
            }
            return redirect()->route('member.show',$data->member_id)->with('success','Berhasil Melengkapi Data');
        }
        else
        {
            return back()->with('error','Gagal Melengkapi Data');
        }
    }

    public function hari(Request $request)
    {
        $data['title'] = 'Laporan Harian';
        $data['today'] = date('Y-m-d');
        if($request->get('tanggal'))
        $data['today'] = $request->get('tanggal');
        $data['transaksi'] = DB::table('tb_transaksi')
            ->join('tb_member','tb_transaksi.member_id','tb_member.member_id')
            ->leftJoin('tb_kendaraan','tb_transaksi.kendaraan_id','tb_kendaraan.kendaraan_id')
            ->leftJoin('tb_satuan','tb_transaksi.satuan_id','tb_satuan.satuan_id')
            ->leftJoin('tb_barang','tb_transaksi.barang_id','tb_barang.barang_id')
            ->leftJoin('tb_tujuan','tb_transaksi.tujuan_id','tb_tujuan.tujuan_id')
            ->whereDate('tb_transaksi.check_in',$data['today'])
            ->whereStatusTransaksi(1)
            ->orderBy('tb_transaksi.no_urut','asc')
            ->get();
        return view('transaksi.hari',$data);
    }

    public function bulan(Request $request)
    {
        $data['title'] = 'Laporan Bulanan';
        $data['month'] = date('m');
        $data['year'] = date('Y');
        if($request->get('bulan'))
            $data['month'] = $request->get('bulan');
        if($request->get('tahun'))
            $data['year'] = $request->get('tahun');
        $data['transaksi'] = DB::table('tb_transaksi')
            ->join('tb_member','tb_transaksi.member_id','tb_member.member_id')
            ->leftJoin('tb_kendaraan','tb_transaksi.kendaraan_id','tb_kendaraan.kendaraan_id')
            ->leftJoin('tb_satuan','tb_transaksi.satuan_id','tb_satuan.satuan_id')
            ->leftJoin('tb_barang','tb_transaksi.barang_id','tb_barang.barang_id')
            ->leftJoin('tb_tujuan','tb_transaksi.tujuan_id','tb_tujuan.tujuan_id')
            ->whereMonth('tb_transaksi.check_in',$data['month'])
            ->whereYear('tb_transaksi.check_in',$data['year'])
            ->whereStatusTransaksi(1)
            ->orderBy('tb_transaksi.no_urut','asc')
            ->get();
        return view('transaksi.bulan',$data);
    }

    public function tahun(Request $request)
    {
        $data['title'] = 'Laporan Tahunan';
        $data['year'] = date('Y');
        if($request->get('tahun'))
            $data['year'] = $request->get('tahun');
        $data['transaksi'] = DB::table('tb_transaksi')
            ->join('tb_member','tb_transaksi.member_id','tb_member.member_id')
            ->leftJoin('tb_kendaraan','tb_transaksi.kendaraan_id','tb_kendaraan.kendaraan_id')
            ->leftJoin('tb_satuan','tb_transaksi.satuan_id','tb_satuan.satuan_id')
            ->leftJoin('tb_barang','tb_transaksi.barang_id','tb_barang.barang_id')
            ->leftJoin('tb_tujuan','tb_transaksi.tujuan_id','tb_tujuan.tujuan_id')
            ->whereYear('tb_transaksi.check_in',$data['year'])
            ->whereStatusTransaksi(1)
            ->orderBy('tb_transaksi.no_urut','asc')
            ->get();
        return view('transaksi.tahun',$data);
    }


    //op2
    public function index_op2()
    {
        $data['title'] = 'Transaksi';
        $today = date('Y-m-d');
        $data['transaksi'] = DB::table('tb_transaksi')
            ->join('tb_member','tb_transaksi.member_id','tb_member.member_id','tb_tujuan.tujuan_id')
            ->leftJoin('tb_kendaraan','tb_transaksi.kendaraan_id','tb_kendaraan.kendaraan_id')
            ->leftJoin('tb_satuan','tb_transaksi.satuan_id','tb_satuan.satuan_id')
            ->leftJoin('tb_barang','tb_transaksi.barang_id','tb_barang.barang_id')
            ->leftJoin('tb_tujuan','tb_transaksi.tujuan_id','tb_tujuan.tujuan_id')
            ->whereDate('tb_transaksi.check_in',$today)
            ->orderBy('tb_transaksi.no_urut','asc')
            ->get();
        return view('transaksi.operator2.index',$data);
    }

    public function complete_op2($id)
    {
        $data['title'] = 'Input Detail Check-In';
        $data['transaksi'] = DB::table('tb_transaksi')
            ->join('tb_member','tb_transaksi.member_id','tb_member.member_id','tb_tujuan.tujuan_id')
            ->whereTransaksiId($id)
            ->first();
        $data['kendaraan'] = DB::table('tb_kendaraan')->whereMemberId($data['transaksi']->member_id)->whereKendaraanHapus(0)->get();
        $data['barang'] = DB::table('tb_barang')->whereBarangHapus(0)->get();
        $data['satuan'] = DB::table('tb_satuan')->whereSatuanHapus(0)->get();
        $data['tujuan'] = DB::table('tb_tujuan')->whereTujuanHapus(0)->get();
        return view('transaksi.operator2.complete',$data);
    }

    public function completeTransaksi_op2(Request $request,$id)
    {
        $this->validate($request, [
            'kendaraan' => 'required',
            'barang' => 'required',
            'satuan' => 'required',
            'status' => 'required',
            'tujuan' => 'required',
            'qty' => 'required',
            'foto' => 'mimes:jpg,jpeg,bmp,png',
        ]);
        $data = DB::table('tb_transaksi')->whereTransaksiId($id)->first();
        $member = DB::table('tb_member')->whereMemberId($data->member_id)->first();
        if($request->status == 1)
        {
            DB::table('tb_member')->whereMemberId($member->member_id)->update(['point' => $member->point + 1]);
        }

        if($request->foto)
        {
            @unlink('bukti/'.$data->foto_barang);
            $thumbnailImage = Image::make($request->foto);
            $thumbnailPath = 'bukti/';
            $thumbnailImage->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $filename = str_replace(' ', '', time() . $request->foto->getClientOriginalName());
            $thumbnailImage->save($thumbnailPath . $filename);
        }
        else
        {
            $filename = $data->foto_barang;
        }
        $update = DB::table('tb_transaksi')
            ->whereTransaksiId($id)
            ->update([
                'kendaraan_id' => $request->kendaraan,
                'barang_id' => $request->barang,
                'satuan_id' => $request->satuan,
                'tujuan_id' => $request->tujuan,
                'qty' => $request->qty,
                'foto_barang' => $filename,
                'status_transaksi' => $request->status,
                'check_out' => Carbon::now()
            ]);
        if($update)
        {
            if($request->status == 1)
            {
                \DB::table('log_point')
                ->insert([
                    'member_id' => $member->member_id,
                    'jumlah' => 1,
                    'type' => 'Plus',
                    'keterangan' => 'Sukses transaksi pada Tanggal : '.Carbon::now(). 'No Urut : '.$data->no_urut,
                ]);
            }
            return redirect()->route('transaksi.index.op2')->with('success','Berhasil Melengkapi Data');
        }
        else
        {
            return back()->with('error','Gagal Melengkapi Data');
        }
    }


}
