<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\WajibPajak;
use App\Tmuser;
use Auth;
use Hash;

class WajibPajakController extends Controller
{
    public function index()
    {
        $wp = DB::table ('tb_wajib_pajak')->orderBy('nama','ASC')->get();
        $data=array(
            'wp' => $wp
        );
        return view ('wajibpajak.index',$data);
    }

    public function create()
    {
      
        return view('wajibpajak.add');
    }

    public function store(Request $request)
    {
         $cek = DB::table('tm_user_login')
                ->where('user_email', '=', $request->email)
                ->where('user_status','Aktif')
                ->where('user_role_id','5')
                ->select('id', 'user_kode','user_email','user_password')
                ->get();
       
            if (count($cek) > 0){

                session()->flash('false','Email atau Username sudah terdaftar');
                return redirect()->route('wajibpajak.index');

            }else{

            $q=DB::table('tb_wajib_pajak')->select(DB::raw('MAX(wp_id) as kd_max'));
            if($q->count()>0){foreach($q->get() as $k){$wp_id = $k->kd_max+1;}
            }else{$wp_id = "1";}
            
            $wajibpajak = new wajibpajak;
            $wajibpajak->wp_id = $wp_id;
            $wajibpajak->npwpd = $request->npwpd;
            $wajibpajak->nama = $request->nama;
            $wajibpajak->alamat = $request->alamat;
            $wajibpajak->tanggal_daftar = $request->tanggal_daftar;
            $wajibpajak->status_wp = 1;
            $wajibpajak->created_at = now();
            $wajibpajak->updated_at = now();
            $wajibpajak->diupdate_oleh = Auth::guard('login')->user()->user_kode;
            $wajibpajak->email = $request->email;
            $wajibpajak->telp = $request->telp;
            $wajibpajak->save(); 

            $q=DB::table('tm_user_login')->select(DB::raw('MAX(id) as kd_max'));
            if($q->count()>0) {foreach($q->get() as $k){$tm_id = $k->kd_max+1;}
            }else{$tm_id = "1";}

            $tmuser = new tmuser;
            $tmuser->id = $tm_id;
            $tmuser->user_email = $request->email;
            $tmuser->user_password = Hash::make('kotasukabumi');
            $tmuser->user_first_name = $request->nama;
            $tmuser->user_last_name = "";
            $tmuser->user_role_id = 5;
            $tmuser->user_avatar = "";
            $tmuser->user_status = "Aktif";
            $tmuser->created_at = now();
            $tmuser->user_kode = $wp_id;
            $tmuser->save(); 

            session()->flash('success','Sukses tambah wajibpajak!');
            return redirect()->route('wajibpajak.index');
        }
    }


    public function edit(wajibpajak $wajibpajak)
    {   
        return view('wajibpajak.edit', compact('wajibpajak'));
    }

    public function update(Request $request, wajibpajak $wajibpajak)
    {
        if($request->status_wp == 1){
            $status="Aktif";
        }elseif($request->status_wp == 0){
            $status="Tidak Aktif";
        }

        $qry= DB::table('tm_user_login')->where('user_kode',$wajibpajak->wp_id)
        ->update ([
                'user_first_name' => $request->nama,
                'user_status' =>  $status
            ]);

      
        $wajibpajak->nama = $request->nama;
        $wajibpajak->npwpd = $request->npwpd;
        $wajibpajak->alamat = $request->alamat;
        $wajibpajak->status_wp = $request->status_wp;
        $wajibpajak->created_at =now(); 
        $wajibpajak->updated_at = now();
        $wajibpajak->keterangan = $status;
        $wajibpajak->diupdate_oleh = Auth::guard('login')->user()->user_kode;
        $wajibpajak->save();
       
        session()->flash('success','Sukses ubah data wajibpajak!');
        return redirect()->route('wajibpajak.index');
    }

    public function resetpassword(Request $request, wajibpajak $wajibpajak)
    {
      
        $qry= DB::table('tm_user_login')->where('user_kode',$wajibpajak->wp_id)
        ->update ([
                'user_password' => Hash::make('kotasukabumi'),
                'updated_at' => now()
            ]);
       
        session()->flash('success','Sukses Reset Password ');
        return redirect()->route('wajibpajak.index');
    }

    public function destroy(wajibpajak $wajibpajak)
    {
        $wajibpajak->delete();

        session()->flash('success','Sukses hapus wajibpajak!');
        return redirect()->back();
    }
}
