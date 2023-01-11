<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HomeController extends Controller
{
    // Admin
    public function index(Request $request)
    {
        $data['title'] = 'Home';
        $find = $request->tahun ?? date("m/Y - m/Y");

        $explode = explode("-", $find); //explode untuk memecah data waktu berdasarkan tanda -
        $start = trim($explode[0]); //trim untuk menghilangkan spasi pada data waktu explode [0] untuk mengambil array pertama
        $end = trim($explode[1]);

        $start = strtotime($start); // format date m/d/Y (01/01/2022) menjadi time : (1640970000)
        $data['start'] = $start;
        $data['ms'] = date("m", $start );
        $start = date("Y-m", $start); // ubah time: 1640970000  menjadi date Y-m-d (2022-01-01)



        $end = strtotime($end);
        $data['end'] = $end;
        $data['me'] = date("m", $end );
        $end = date('Y-m', $end);

        $data['home'] = DB::table("tb_transaksi")
        ->select("tb_transaksi.*",)
        ->whereBetween("tb_transaksi.check_in", [$start, $end.' 23:59:59'])
        ->get();
        return view('home',$data);
    }


    // Operator
    public function indexOperator(Request $request)
    {
        $data['title'] = 'Home';
        $find = $request->tahun ?? date("m/Y - m/Y");

        $explode = explode("-", $find); //explode untuk memecah data waktu berdasarkan tanda -
        $start = trim($explode[0]); //trim untuk menghilangkan spasi pada data waktu explode [0] untuk mengambil array pertama
        $end = trim($explode[1]);

        $start = strtotime($start); // format date m/d/Y (01/01/2022) menjadi time : (1640970000)
        $data['start'] = $start;
        $data['ms'] = date("m", $start );
        $start = date("Y-m", $start); // ubah time: 1640970000  menjadi date Y-m-d (2022-01-01)



        $end = strtotime($end);
        $data['end'] = $end;
        $data['me'] = date("m", $end );
        $end = date('Y-m', $end);

        $data['home'] = DB::table("tb_transaksi")
        ->select("tb_transaksi.*",)
        ->whereBetween("tb_transaksi.check_in", [$start, $end.' 23:59:59'])
        ->get();
        return view('home',$data);
    }

    public function indexOperator2(Request $request)
    {
        $data['title'] = 'Home';
        $find = $request->tahun ?? date("m/Y - m/Y");

        $explode = explode("-", $find); //explode untuk memecah data waktu berdasarkan tanda -
        $start = trim($explode[0]); //trim untuk menghilangkan spasi pada data waktu explode [0] untuk mengambil array pertama
        $end = trim($explode[1]);

        $start = strtotime($start); // format date m/d/Y (01/01/2022) menjadi time : (1640970000)
        $data['start'] = $start;
        $data['ms'] = date("m", $start );
        $start = date("Y-m", $start); // ubah time: 1640970000  menjadi date Y-m-d (2022-01-01)



        $end = strtotime($end);
        $data['end'] = $end;
        $data['me'] = date("m", $end );
        $end = date('Y-m', $end);

        $data['home'] = DB::table("tb_transaksi")
        ->select("tb_transaksi.*",)
        ->whereBetween("tb_transaksi.check_in", [$start, $end.' 23:59:59'])
        ->get();
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
