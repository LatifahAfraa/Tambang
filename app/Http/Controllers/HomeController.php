<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    // Admin
    public function index(Request $request)
    {
        $data['title'] = 'Home';
        $find = $request->tahun ?? date("01/01/2022 - 12/31/2022");

        $explode = explode("-", $find); //explode untuk memecah data waktu berdasarkan tanda -
        $start = Carbon::parse($explode[0])->format('Y-m-d') . ' 00:00:01';
        $data['month_start'] = date('m');
        $data['start'] = $start;

        $end = Carbon::parse($explode[1])->format('Y-m-d') . ' 23:59:59';
        $data['month_end'] = date('m');
        $data['end'] = $end;



        $tb_transaksi = DB::table("tb_transaksi")
        // ->select('') berdasarkan field
        ->selectRaw("MONTH(check_in) as month, SUM(qty) as qty") //bisa menjalankan function bawaan sql
        ->whereStatusTransaksi(1)
        ->whereBetween('check_in', [$start, $end])
        ->groupByRaw('MONTH(check_in)') // raw bisa menjalankan function
        ->get();

        $data['transaksi'] = [];
        foreach ($tb_transaksi as $key => $transaksi) {
            $data['transaksi'][$transaksi->month] = $transaksi->qty;
        }

        return view('home',$data);
    }


    // Operator
    public function indexOperator(Request $request)
    {
        $data['title'] = 'Home';
        $find = $request->tahun ?? date("01/01/2022 - 12/31/2022");

        $explode = explode("-", $find); //explode untuk memecah data waktu berdasarkan tanda -
        $start = Carbon::parse($explode[0])->format('Y-m-d') . ' 00:00:01';
        $data['month_start'] = date('m');
        $data['start'] = $start;

        $end = Carbon::parse($explode[1])->format('Y-m-d') . ' 23:59:59';
        $data['month_end'] = date('m');
        $data['end'] = $end;



        $tb_transaksi = DB::table("tb_transaksi")
        // ->select('') berdasarkan field
        ->selectRaw("MONTH(check_in) as month, SUM(qty) as qty") //bisa menjalankan function bawaan sql
        ->whereStatusTransaksi(1)
        ->whereBetween('check_in', [$start, $end])
        ->groupByRaw('MONTH(check_in)') // raw bisa menjalankan function
        ->get();

        $data['transaksi'] = [];
        foreach ($tb_transaksi as $key => $transaksi) {
            $data['transaksi'][$transaksi->month] = $transaksi->qty;
        }

        return view('home',$data);
    }

    public function indexOperator2(Request $request)
    {
        $data['title'] = 'Home';
        $find = $request->tahun ?? date("01/01/2022 - 12/31/2022");

        $explode = explode("-", $find); //explode untuk memecah data waktu berdasarkan tanda -
        $start = Carbon::parse($explode[0])->format('Y-m-d') . ' 00:00:01';
        $data['month_start'] = date('m');
        $data['start'] = $start;

        $end = Carbon::parse($explode[1])->format('Y-m-d') . ' 23:59:59';
        $data['month_end'] = date('m');
        $data['end'] = $end;



        $tb_transaksi = DB::table("tb_transaksi")
        // ->select('') berdasarkan field
        ->selectRaw("MONTH(check_in) as month, SUM(qty) as qty") //bisa menjalankan function bawaan sql
        ->whereStatusTransaksi(1)
        ->whereBetween('check_in', [$start, $end])
        ->groupByRaw('MONTH(check_in)') // raw bisa menjalankan function
        ->get();

        $data['transaksi'] = [];
        foreach ($tb_transaksi as $key => $transaksi) {
            $data['transaksi'][$transaksi->month] = $transaksi->qty;
        }

        return view('home',$data);
    }

    public function auth(Request $request){

    	$username = $request->get('username');
    	$password = $request->get('password');

    	if (Auth::guard('admin')->attempt(['username' => $username, 'password' => $password ],true)) {
            if(Auth::guard('admin')->user()->level === "Admin")
            {
                return redirect('/admin');
            }
            elseif(Auth::guard('admin')->user()->level === "Operator")
            {
                if(Auth::guard('admin')->user()->hapus === 1)
                {
                    return back()->with('error','Akun ini telah dihapus ! ! !');
                }
                if(Auth::guard('admin')->user()->aktif === 1)
                {
                    return back()->with('error','Akun ini telah dinonaktifkan ! ! !');
                }
                return redirect()->route('home.index');
            }
            else
            {
                return redirect()->route('home.index2');
            }
		}else{
            return redirect()->route('login')->with('error','Username atau Password Salah ! ! !');
        }
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('login');
    }

    // Cetak QR Optional
    // public function qr()
    // {
    //     return view('qr');
    // }

    // mobile
    public function loginMobile(Request $request)
    {
        $token = Auth::guard('admin-mobile')->attempt(["username" => $request->username, "password" => $request->password]);
        if ($token) {
            return $this->respondWithToken($token);
        } else {
            return response()->json(['status' => 400, 'message' => 'Cek kembali password anda']);
        }
    }

    protected function respondWithToken($token)
    {
        $user = User::find(Auth::guard('admin-mobile')->user()->id);
        return response()->json([
            'status' => 200,
            'access_token' => $token,
            'token_type' => 'bearer',
            'data' => $user
        ]);
    }
}
