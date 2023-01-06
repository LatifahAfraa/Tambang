<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OperatorController extends Controller
{
    //
    public function index()
    {
        $data['title'] = 'Operator';
        $data['operator'] = \DB::table('users')->whereHapus(0)->whereLevel('Operator')->get();
        return view('operator.index',$data);
    }

    public function create()
    {
        $data['title'] = 'Operator';
        return view('operator.create',$data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|alpha',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6|confirmed',
        ]);

        $insert = \DB::table('users')
            ->insert([
                'name' => $request->name,
                'username' => $request->username,
                'password' => \Hash::make($request->password),
                'level' => 'Operator'
            ]);

        if($insert)
        {
            return redirect('admin/operator')->with('success', 'Data berhasil ditambahkan');
        }
        else
        {
            return back()->with('error', 'Data gagal ditambahkan');
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Operator';
        $data['operator'] = \DB::table('users')->whereId($id)->first();
        return view('operator.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|alpha',
            'username' => ['required',Rule::unique('users', 'username')->ignore($id, 'id'),],
            'password' => 'confirmed',
        ]);
        $user = \DB::table('users')->whereId($id)->first();
        $update = \DB::table('users')
            ->whereId($id)
            ->update([
                'name' => $request->name,
                'username' => $request->username,
                'password' => $request->password ? \Hash::make($request->password) : $user->password,
            ]);

        if($update)
        {
            return redirect('admin/operator')->with('success', 'Data berhasil dubah');
        }
        else
        {
            return back()->with('error', 'Data gagal dubah');
        }
    }

    public function destroy($id)
    {
        $data = \DB::table('users')->whereId($id)->update(['hapus' => 1]);
        if($data)
        {
            return back()->with('success', 'Data berhasil dihapus');
        }
        else
        {
            return back()->with('error', 'Data gagal dihapus');
        }
    }
}
