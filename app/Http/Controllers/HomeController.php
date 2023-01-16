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
    public function index()
    {
        $data['title'] = 'Home';
        return view('home',$data);
    }


    // Operator
    public function indexOperator()
    {
        $data['title'] = 'Home';
        return view('home',$data);
    }

    public function indexOperator2()
    {
        $data['title'] = 'Home';
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
