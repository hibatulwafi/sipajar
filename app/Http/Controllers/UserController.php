<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Hash;
use App\Tmuser;
use App\Level;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $user = DB::table('tm_user_login')
        ->join('tm_user_role','tm_user_login.user_role_id','tm_user_role.user_role_id')
        ->where('tm_user_login.user_role_id','3')
        ->orWhere('tm_user_login.user_role_id','4')
        ->get();
        $data=array(
            'user' => $user
        );        
        return view ('user.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $role = DB::table ('tm_user_role')->where('user_role_id',3)->orWhere('user_role_id',4)->get();
        $data=array(
            'roles' => $role
        );
        return view('user.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $q=DB::table('tm_user_login')->select(DB::raw('MAX(id) as kd_max'));
        if($q->count()>0) {foreach($q->get() as $k){$tm_id = $k->kd_max+1;}
        }else{$tm_id = "1";}

        $tmuser = new tmuser;
        $tmuser->id = $tm_id;
        $tmuser->user_email = $request->email;
        $tmuser->user_password = Hash::make($request->password);
        $tmuser->user_first_name = $request->nama_depan;
        $tmuser->user_last_name = $request->nama_belakang;
        $tmuser->user_role_id = $request->role;
        $tmuser->user_avatar = "";
        $tmuser->user_status = "Aktif";
        $tmuser->created_at = now();
        $tmuser->user_kode = 0;
        $tmuser->save(); 

        session()->flash('success','Sukses tambah Data ! '.$tmuser->user_first_name." ".$tmuser->user_last_name);
        return redirect()->route('pengguna.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = tmuser::findOrFail($id);
        $roles = DB::table ('tm_user_role')->where('user_role_id',3)->orWhere('user_role_id',4)->get();

        return view('user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      
        $user = tmuser::findOrFail($id);
        $user->user_first_name = $request->nama_depan;
        $user->user_last_name = $request->nama_belakang;
        $user->user_email = $request->email;
        $user->user_role_id = $request->role;
        $user->user_status = $request->status;
        $user->updated_at = now();
        if(!empty($request->password)) {
            $user->user_password = Hash::make($request->password);
        }
        $user->save();

        session()->flash('success','Sukses Ubah Data Pengguna '.$user->name);
        return redirect()->route('pengguna.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = tmuser::findOrFail($id);
        $user->delete();

        session()->flash('success','Sukses Hapus Pengguna!');
        return redirect()->route('pengguna.index');

    }
}
