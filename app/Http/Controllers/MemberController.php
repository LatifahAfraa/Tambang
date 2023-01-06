<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Image;
use App\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    //
    public function index()
    {
        $data['title'] = 'Member';
        $data['member'] = DB::table('tb_member')->whereMemberHapus(0)->get();
        return view('member.index',$data);
    }

    public function status($id, $value)
    {
        if($value == 1)
        {
            DB::table('tb_member')->whereMemberId($id)->update(['member_status' => $value]);
            return back()->with('success','Pengajuan Supir diterima');
        }
        else
        {
            $data = DB::table('tb_member')->whereMemberId($id)->first();
            @unlink('member/'.$data->member_foto);
            DB::table('tb_member')->whereMemberId($id)->delete();
            return back()->with('error','Pengajuan Supir ditolak');
        }
    }

    public function show($id)
    {
        $data['member'] = Member::find($id);
        $data['title'] = 'Detail Member - '.$data['member']->member_nama;
        $data['transaksi'] = DB::table('tb_transaksi')
            ->join('tb_member','tb_transaksi.member_id','tb_member.member_id')
            ->leftJoin('tb_kendaraan','tb_transaksi.kendaraan_id','tb_kendaraan.kendaraan_id')
            ->leftJoin('tb_satuan','tb_transaksi.satuan_id','tb_satuan.satuan_id')
            ->leftJoin('tb_barang','tb_transaksi.barang_id','tb_barang.barang_id')
            ->where('tb_transaksi.member_id',$id)
            ->get();
        return view('member.show',$data);
    }

    public function destroy($id)
    {
        $delete = DB::table('tb_member')
            ->whereMemberId($id)
            ->update([
                'member_hapus' => 1,
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

    public function point(Request $request,$id)
    {
        $member = DB::table('tb_member')->whereMemberId($id)->first();
        $update = DB::table('tb_member')
            ->whereMemberId($id)
            ->update([
                'point' => $member->point - $request->point
            ]);
        if($update)
        {
            \DB::table('log_point')
                ->insert([
                    'member_id' => $id,
                    'jumlah' => $request->point,
                    'type' => 'Minus',
                    'keterangan' => $request->keterangan
                ]);
            return back()->with('success','Pemotongan berhasil dilakukan.');
        }
        else
        {
            return back()->with('error','Pemotongan gagal dilakukan.');
        }
    }

    public function member()
    {
        $data['title'] = 'Member';
        $data['member'] = DB::table('tb_member')->whereMemberHapus(0)->get();
        return view('member.member',$data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Member';
        return view('member.create',$data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'member_nama' => 'required',
            'member_alamat' => 'required',
            'member_email' => 'required',
            'password' => 'required',
            'member_nohp' => 'required',
            'member_foto'=>'required|file|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $file = $request->file('member_foto');
        $nama_file = time()."_".$file->getClientOriginalName();
        $tujuan_upload = 'storage/post-image';
		$file->move($tujuan_upload,$nama_file);
        
        
        $insert = DB::table('tb_member')
            ->insert([
                'member_nama' => $request->member_nama,
                'member_alamat' => $request->member_alamat,
                'member_email' => $request->member_email,
                'password' => \Hash::make($request->password),
                'member_nohp' => $request->member_nohp,
                'member_foto' =>$nama_file,
                
            ]);

        if($insert)
        {
            return redirect()->route('tampil.member')->with('success','Data berhasil ditambahkan');
        }
        else
        {
            return redirect()->route('member.create')->with('error','Data gagal ditambahkan');
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Member';
        $data['member'] = DB::table('tb_member')->whereMemberId($id)->first();
        return view('member.edit',$data);
    }

    public function update(Request $request, $id)
    {
           
        $this->validate($request, [
            'member_nama' => 'required',
            'member_alamat' => 'required',
            'member_email' => 'required',
            'password' => 'required',
            'member_nohp' => 'required',
            'member_foto'=>'required|file|image|mimes:jpeg,png,jpg'
        ]);
        
        $file = $request->file('member_foto');
        $nama_file = time()."_".$file->getClientOriginalName();
        $tujuan_upload = 'storage/post-image';
		$file->move($tujuan_upload,$nama_file);

        $update = DB::table('tb_member')
            ->whereMemberId($id)
            ->update([
                'member_nama' => $request->member_nama,
                'member_alamat' => $request->member_alamat,
                'member_email' => $request->member_email,
                'password' => \Hash::make($request->password),
                'member_nohp' => $request->member_nohp,
                'member_foto' =>$nama_file
            ]);

        if($update)
        {
            return redirect()->route('tampil.member')->with('success','Data berhasil diupdate');
        }
        else
        {
            return redirect()->route('member.create')->with('error','Data gagal diupdate');
        }
        
    }

    public function destroy_member($id)
    {
        $delete = DB::table('tb_member')
            ->whereMemberId($id)
            ->update([
                'member_hapus' => 1,
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




    // Mobile
    public function checkEmail(Request $request)
    {
        $cek = DB::table('tb_member')->whereMemberEmail($request->email)->first();
        if($cek)
        {
            return response()->json(['status' => 400, 'message' => 'Email sudah digunakan.']);
        }
        else
        {
            return response()->json(['status' => 200, 'message' => 'Email bisa digunakan.']);
        }
    }

    //jangan ditimpa
  public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'nama' => 'required',
            'alamat' => 'required',
            'nohp' => 'required',
            'foto' => 'required|mimes:jpeg,jpg,png',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => $validator->messages()]);
        }
        else
        {
            $thumbnailImage = Image::make($request->foto);
            $thumbnailPath = 'member/';
            $thumbnailImage->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $filename = str_replace(' ', '', time() . $request->foto->getClientOriginalName());
            $thumbnailImage->save($thumbnailPath . $filename);

            $insert = DB::table('tb_member')
                ->insert([
                    'member_nama' => $request->nama,
                    'member_alamat' => $request->alamat,
                    'member_email' => $request->email,
                    'member_nohp' => $request->nohp,
                    'password' => \Hash::make($request->password),
                    'member_foto' => $filename,
                ]);
            if($insert)
            {
                return response()->json(['status' => 200, 'message' => 'Registrasi telah dikirim.']);
            }
            else
            {
                return response()->json(['status' => 400, 'message' => 'Registrasi gagal dikirim.']);
            }
        }
    }

    public function login(Request $request)
    {
        $token = Auth::guard('member')->attempt(["member_email" => $request->email, "password" => $request->password]);
        if ($token) {
            $member = Member::find(Auth::guard('member')->user()->member_id);
            if ($member->member_hapus == 0 && $member->member_status == 1 && $member->member_aktif == 0)
            {
                return $this->respondWithToken($token);
            }
            elseif($member->member_status == 0)
            {
                return response()->json(['status' => 400, 'message' => 'Akun anda belum dikonfirmasi']);
            }
            elseif($member->member_status == 2)
            {
                return response()->json(['status' => 400, 'message' => 'Akun anda telah ditolak']);
            }
            elseif($member->member_aktif == 1)
            {
                return response()->json(['status' => 400, 'message' => 'Akun anda telah dinonaktifkan']);
            }
            else
            {
                return response()->json(['status' => 400, 'message' => 'Akun anda telah dihapus']);
            }
        } else {
            return response()->json(['status' => 400, 'message' => 'Cek kembali password anda']);
        }
    }

    protected function respondWithToken($token)
    {
        $member = Member::find(Auth::guard('member')->user()->member_id);
        return response()->json([
            'status' => 200,
            'access_token' => $token,
            'token_type' => 'bearer',
            'data' => $member
        ]);
    }

    public function regisKendaraan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no' => 'required',
            'jenis' => 'required',
            'type' => 'required',
            'brand' => 'required',
            'foto' => 'required|mimes:jpeg,jpg,png',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'message' => $validator->messages()]);
        }
        else
        {
            $thumbnailImage = Image::make($request->foto);
            $thumbnailPath = 'kendaraan/';
            $thumbnailImage->resize(600, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $filename = str_replace(' ', '', time() . $request->foto->getClientOriginalName());
            $thumbnailImage->save($thumbnailPath . $filename);

            $insert = DB::table('tb_kendaraan')
                ->insert([
                    'member_id' => Auth::guard('member')->user()->member_id,
                    'no_pol' => $request->no,
                    'jenis' => $request->jenis,
                    'type' => $request->type,
                    'brand' => $request->brand,
                    'kendaraan_foto' => $filename,
                ]);
            if($insert)
            {
                return response()->json(['status' => 200, 'message' => 'Registrasi kendaraan telah disimpan.']);
            }
            else
            {
                return response()->json(['status' => 400, 'message' => 'Registrasi kendaraan gagal disimpan.']);
            }
        }
    }

    public function checkIn(Request $request)
    {
        $today = date('Y-m-d');
        
        // check data in supir
        $dataIn = \DB::table('tb_transaksi')->whereDate('check_in',$today)->orderBy('transaksi_id','desc')->first();
        if($dataIn === null || $dataIn->check_out !== null)
        {
            // tambahkan data
            $cek = \DB::table('setting')->first();

            // cek jarak
            $my_latitude = $request->lat;
            $my_longitude = $request->long;
            $clat = $cek->latitude;
            $clong = $cek->longitude;
    
            $distance = round((((acos(sin(($my_latitude*pi()/180)) * sin(($clat*pi()/180))+cos(($my_latitude*pi()/180)) * cos(($clat*pi()/180)) * cos((($my_longitude- $clong)*pi()/180))))*180/pi())*60*1.1515*1.609344), 2);
    
            $area = (int)$distance;
            // if($area < 0.010)
            // {
                if($cek->spesial_id === $request->spesial_id)
                {
                    $validator = Validator::make($request->all(), [
                        'kendaraan' => 'required|numeric',
                        'lat' => 'required',
                        'long' => 'required',
                    ]);
    
                    if ($validator->fails()) {
                        return response()->json(['status' => 400, 'message' => $validator->messages()]);
                    }
                    else
                    {
                        $nomor = \DB::table('tb_transaksi')->whereDate('check_in',$today)->orderBy('no_urut','desc')->first();
                        if($nomor)
                        {
                            $no = $nomor->no_urut;
                            $no = (int)$no+1;
                        } else {
                            $no = 1;
                        }
                        $insert = DB::table('tb_transaksi')
                            ->insert([
                                'member_id' => Auth::guard('member')->user()->member_id,
                                'kendaraan_id' => $request->kendaraan,
                                'latitude' => $request->lat,
                                'longitude' => $request->long,
                                'no_urut' => $no,
                            ]);
                        if($insert)
                        {
                            return response()->json(['status' => 200, 'message' => 'Anda Berhasil Check-in '. Auth::guard('member')->user()->member_nama]);
                        }
                        else
                        {
                            return response()->json(['status' => 400, 'message' => 'Check-in gagal dilakukan']);
                        }
                    }
                }
                else
                {
                    return response()->json(['status' => 400, 'message' => 'Invalid Qr Please Check Again']);
                }
            // }
            // else
            // {
            //     return response()->json(['status' => 400, 'message' => 'Anda Belum Memasuki Area ! ! !']);
            // }
        }
        else
        {
            if($dataIn->check_out === null)
            {
                // tolak data
                return response()->json(['status' => 400, 'message' =>'Anda telah melakukan Check-In']);
            }
        }
    }

    public function checkOut(Request $request)
    {
        $today = date('Y-m-d');
        $update = \DB::table('tb_transaksi')
            ->whereDate('check_in',$today)
            ->where('check_out', NULL)
            ->update([
                'check_out' => Carbon::now()
            ]);
        if($update)
        {
            return response()->json(['status' => 200, 'message' => 'Anda Berhasil Check-out '. Auth::guard('member')->user()->member_nama]);
        }
        else
        {
            return response()->json(['status' => 400, 'message' => 'Check-out gagal dilakukan']);
        }
    }

    public function profile()
    {
        $data = \DB::table('tb_member')->whereMemberId(Auth::guard('member')->user()->member_id)->first();
        return response()->json(['status' => 200, 'message' => 'Data ditemukan', 'data' => $data]);
    }

    public function kendaraanMember()
    {
        $kendaraan = \DB::table('tb_kendaraan')->whereMemberId(Auth::guard('member')->user()->member_id)->whereKendaraanHapus(0)->get();
        return response()->json(['status' =>200, 'message' => 'Data ditemukan', 'data' => $kendaraan]);
    }

    public function listPoint()
    {
        $data['point'] = Auth::guard('member')->user()->point;
        $data['riwayat'] = \DB::table('log_point')->whereMemberId(Auth::guard('member')->user()->member_id)->orderBy('created_at','desc')->get();
        return response()->json(['status' => 200, 'message' => 'Data ditemukan', 'data' => $data]);
    }

    public function listCheckIn()
    {
        $today = date('Y-m-d');
        $data = \DB::table('tb_transaksi')
            ->join('tb_kendaraan','tb_transaksi.kendaraan_id','tb_kendaraan.kendaraan_id')
            ->where('tb_transaksi.member_id',Auth::guard('member')->user()->member_id)
            ->whereDate('check_in',$today)
            ->where('check_out','=', NULL)
            ->get();
        return response()->json(['status' => 200, 'message' => 'Data ditemukan', 'data' => $data]);
    }

    public function listCheckOut()
    {
        $today = date('Y-m-d');
        $data = \DB::table('tb_transaksi')
            ->join('tb_kendaraan','tb_transaksi.kendaraan_id','tb_kendaraan.kendaraan_id')
            ->where('check_out','!=',NULL)
            ->whereDate('check_out',$today)
            ->where('tb_transaksi.member_id',Auth::guard('member')->user()->member_id)
            ->get();
        return response()->json(['status' => 200, 'message' => 'Data ditemukan', 'data' => $data]);
    }
}
