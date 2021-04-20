<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;

class PesanController extends Controller
{
    public function form(){

        $outbox = DB::table ('tb_pesan')->where('pengirim',Auth::guard('login')->user()->user_kode)->where('status',1)->count();
        $total = DB::table ('tb_pesan')->where('penerima',0)->where('status',1)->count();
        $sampah = DB::table ('tb_pesan')->where('status',0)->count();
      
        $wp = DB::table ('tb_wajib_pajak')->get();
        $data=array(
            'total' => $total,
            'outbox' => $outbox,
            'sampah' => $sampah,
            'wp' => $wp
        );
        return view ('pesan.add',$data);
    }
    
    public function inbox(){
      

        $qry = DB::table ('tb_pesan')->orderBy('tb_pesan.tanggal','Desc')
        ->join('tm_user_login', 'tm_user_login.user_kode','tb_pesan.pengirim')
        ->where('penerima',0)
        ->where('status',1)
        ->get();

        $outbox = DB::table ('tb_pesan')->where('pengirim',Auth::guard('login')->user()->user_kode)->where('status',1)->count();
        $total = DB::table ('tb_pesan')->where('penerima',0)->where('status',1)->count();
        $sampah = DB::table ('tb_pesan')->where('status',0)->count();
        $data=array(
            'pesan' => $qry,
            'total' => $total,
            'outbox' => $outbox,
            'sampah' => $sampah
        );
        return view ('pesan.inbox',$data);
    }

     public function outbox(){
        $qry = DB::table ('tb_pesan')
        ->join('tm_user_login', 'tm_user_login.user_kode','tb_pesan.penerima')
        ->where('pengirim',Auth::guard('login')->user()->user_kode)
        ->where('status',1)
        ->get();

        $outbox = DB::table ('tb_pesan')->where('status',1)->where('pengirim',Auth::guard('login')->user()->user_kode)->count();
        $total = DB::table ('tb_pesan')->where('status',1)->where('penerima',0)->count();
        $sampah = DB::table ('tb_pesan')->where('status',0)->count();
        $data=array(
            'pesan' => $qry,
            'total' => $total,
            'outbox' => $outbox,
            'sampah' => $sampah
        );
        return view ('pesan.outbox',$data);
    }

     public function trash(){
        $qry = DB::table ('tb_pesan')
        ->join('tm_user_login', 'tm_user_login.user_kode','tb_pesan.pengirim')
        ->where('penerima',0)
        ->where('status',0)
        ->get();

        $outbox = DB::table ('tb_pesan')->where('pengirim',Auth::guard('login')->user()->user_kode)->count();
        $total = DB::table ('tb_pesan')->where('status',1)->where('penerima',0)->count();
        $sampah = DB::table ('tb_pesan')->where('status',0)->count();
        $data=array(
            'pesan' => $qry,
            'total' => $total,
            'outbox' => $outbox,
            'sampah' => $sampah
        );
        return view ('pesan.trash',$data);
    }

    public function delete(Request $request){
        $qry = DB::table ('tb_pesan')->where('pesan_id',$request->id)
        ->update ([
                'status' => '0'
            ]);
            $pesan="Data Berhasil Di Hapus";

        if ($qry) {
            session()->flash('success','Sukses hapus data !');
            return redirect()->route('inbox');
        }else{
            session()->flash('success','Gagal hapus data !');
            return redirect()->route('inbox');
        }


        }

     public function everdelete(Request $request){
        $qry = DB::table ('tb_pesan')->where('pesan_id',$request->id)
        ->delete();
        
        $pesan="Data Berhasil Di Hapus";

        if ($qry) {
            session()->flash('success','Sukses hapus data !');
            return redirect()->route('inbox');
        }else{
            session()->flash('success','Gagal hapus data !');
            return redirect()->route('inbox');
        }


        }

    public function kirimpesan(Request $request){
      
        $pesan_isi = $request->pesan_isi;
        $pesan_subjek = $request->pesan_subjek;
        $penerima = $request->penerima;
        
    
            $data = DB::table('tb_pesan')->insert([
                'pesan_isi' => $pesan_isi,
                'pesan_subjek' =>   $pesan_subjek,
                'pengirim' =>  Auth::guard('login')->user()->user_kode,
                'penerima'  =>  $penerima,
                'tanggal' => now(),
                'status' => 1,
        
            ]);

            if ($data !== false) {
                return redirect()->route('outbox');
            } else {
                return redirect()->route('kirimpesan');    
            }


    }
}
