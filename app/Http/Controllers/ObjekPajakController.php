<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\WajibPajak;
use App\ObjekPajak;
use App\Kota;
use App\Jenis;
use Illuminate\Database\Eloquent\Model;

class ObjekPajakController extends Controller
{
    public function index()
    {
       $op = DB::table ('tb_objek_pajak')
        ->join('tm_kriteria', 'tb_objek_pajak.kriteria_id','tm_kriteria.kriteria_id')
        ->join('tb_wajib_pajak', 'tb_objek_pajak.wp_id','tb_wajib_pajak.wp_id')
        ->get(); 
        $data=array(
            'op' => $op
        );
        return view ('objekpajak.index',$data);
    }

    public function create()
    {
        $kriteria = DB::table ('tm_kriteria')->get();
        $hargabaku = DB::table ('tm_harga_baku')->get();
        $kelompok = DB::table ('tb_kelompok')->orderBy('kelompok_id','Desc')->get();
        $kelurahan = DB::table ('tb_kelurahan')->get();
        $wp = DB::table ('tb_wajib_pajak')->get();
        $data=array(
            'combo1' => $kriteria,
            'combo2' => $kelurahan,
            'combo3' => $wp,
            'combo4' => $hargabaku,
            'combo5' => $kelompok
        );
        return view('objekpajak.add',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'wp_id' => 'required',
            'op_nama' => 'required',
            'op_alamat' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'kelurahan_id' => 'required',
            'kelompok_id' => 'required',
            'harga_id' => 'required',
            'status_meteran' => 'required',
            'kriteria_id' => 'required',
            'mesin_merk' => 'required',
            'kapasitas_maksimal' => 'required',
            'nomor_ipat' => 'required',
            'kapasitas_minimal' => 'required',
        ]);

        $q=DB::table('tb_objek_pajak')->select(DB::raw('MAX(op_id) as kd_max'));
        if($q->count()>0){foreach($q->get() as $k){$op_id = $k->kd_max+1;}
        }else{$op_id = "1";}

        $objekpajak = new objekpajak;
        $objekpajak->op_id = $op_id;
        $objekpajak->wp_id = $request->wp_id;
        $objekpajak->op_nama = $request->op_nama;
        $objekpajak->op_alamat = $request->op_alamat;
        $objekpajak->longitude = $request->longitude;
        $objekpajak->latitude = $request->latitude;
        $objekpajak->created_at = now();
        $objekpajak->updated_at = now();
        $objekpajak->kelurahan_id = $request->kelurahan_id; 
        $objekpajak->kelompok_id = $request->kelompok_id; 
        $objekpajak->harga_id = $request->harga_id;
        $objekpajak->status_meteran = $request->status_meteran;
        $objekpajak->kriteria_id = $request->kriteria_id;
        $objekpajak->mesin_merk = $request->mesin_merk;
        $objekpajak->kapasitas = $request->kapasitas_maksimal;
        $objekpajak->nomor_ipat = $request->nomor_ipat;
        $objekpajak->status_op = 1;
        $objekpajak->tanggal_registrasi = now(); 
        $objekpajak->kapasitas_minimal = $request->kapasitas_minimal;
        $objekpajak->kapasitas_maksimal = $request->kapasitas_maksimal;
        $objekpajak->save(); 

        session()->flash('success','Sukses tambah objekpajak!');
        return redirect()->route('objekpajak.index');
    }


    public function edit(objekpajak $objekpajak)
    {  
        $cek1= DB::table('tb_kelurahan')->where('kelurahan_id',$objekpajak->kelurahan_id)->get();
        $cek2= DB::table('tb_wajib_pajak')->where('wp_id',$objekpajak->wp_id)->get();
        $cek3= DB::table('tm_harga_baku')->where('harga_id',$objekpajak->harga_id)->get();
        $cek4= DB::table('tm_kriteria')->where('kriteria_id',$objekpajak->kriteria_id)->get();
        $cek5= DB::table('tb_kelompok')->where('kelompok_id',$objekpajak->kelompok_id)->get();

        $combo1= DB::table('tb_kelurahan')->where('kelurahan_id','NOT LIKE',$objekpajak->kelurahan_id)->get();
        $combo2= DB::table('tb_wajib_pajak')->where('wp_id','NOT LIKE',$objekpajak->wp_id)->get();
        $combo3= DB::table('tm_harga_baku')->where('harga_id','NOT LIKE',$objekpajak->harga_id)->get();
        $combo4= DB::table('tm_kriteria')->where('kriteria_id','NOT LIKE',$objekpajak->kriteria_id)->get();
        $combo5= DB::table('tb_kelompok')->where('kelompok_id','NOT LIKE',$objekpajak->kelompok_id)->get();

        return view('objekpajak.edit', compact('objekpajak','cek1','cek2','cek3','cek4','cek5','combo1','combo2','combo3','combo4','combo5'));
    }

    public function update(Request $request, objekpajak $objekpajak)
    {
        $request->validate([
            'wp_id' => 'required',
            'op_nama' => 'required',
            'op_alamat' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'kelurahan_id' => 'required',
            'kelompok_id' => 'required',
            'harga_id' => 'required',
            'status_meteran' => 'required',
            'kriteria_id' => 'required',
            'mesin_merk' => 'required',
            'kapasitas_maksimal' => 'required',
            'nomor_ipat' => 'required',
            'kapasitas_minimal' => 'required',
        ]);

        
        $objekpajak->wp_id = $request->wp_id;
        $objekpajak->op_nama = $request->op_nama;
        $objekpajak->op_alamat = $request->op_alamat;
        $objekpajak->longitude = $request->longitude;
        $objekpajak->latitude = $request->latitude;
        $objekpajak->created_at = now();
        $objekpajak->updated_at = now();
        $objekpajak->kelurahan_id = $request->kelurahan_id; 
        $objekpajak->kelompok_id = $request->kelompok_id; 
        $objekpajak->harga_id = $request->harga_id;
        $objekpajak->status_meteran = $request->status_meteran;
        $objekpajak->kriteria_id = $request->kriteria_id;
        $objekpajak->mesin_merk = $request->mesin_merk;
        $objekpajak->kapasitas = $request->kapasitas_maksimal;
        $objekpajak->nomor_ipat = $request->nomor_ipat;
        $objekpajak->status_op = 1;
        $objekpajak->tanggal_registrasi = now(); 
        $objekpajak->kapasitas_minimal = $request->kapasitas_minimal;
        $objekpajak->kapasitas_maksimal = $request->kapasitas_maksimal;
        $objekpajak->save(); 

        session()->flash('success','Sukses ubah data objekpajak!');
        return redirect()->route('objekpajak.index');
    }

    public function destroy(objekpajak $objekpajak)
    {
        $objekpajak->delete();
        session()->flash('success','Sukses hapus objekpajak !');
        return redirect()->back();
    }

     public function detail(Request $request, objekpajak $objekpajak)
    {
        $cek1= DB::table('tb_kelurahan')->where('kelurahan_id',$objekpajak->kelurahan_id)->get();
        $cek2= DB::table('tb_wajib_pajak')->where('wp_id',$objekpajak->wp_id)->get();
        $cek3= DB::table('tm_harga_baku')->where('harga_id',$objekpajak->harga_id)->get();
        $cek4= DB::table('tm_kriteria')->where('kriteria_id',$objekpajak->kriteria_id)->get();
        $cek5= DB::table('tb_kelompok')->where('kelompok_id',$objekpajak->kelompok_id)->get();

        $combo1= DB::table('tb_kelurahan')->where('kelurahan_id','NOT LIKE',$objekpajak->kelurahan_id)->get();
        $combo2= DB::table('tb_wajib_pajak')->where('wp_id','NOT LIKE',$objekpajak->wp_id)->get();
        $combo3= DB::table('tm_harga_baku')->where('harga_id','NOT LIKE',$objekpajak->harga_id)->get();
        $combo4= DB::table('tm_kriteria')->where('kriteria_id','NOT LIKE',$objekpajak->kriteria_id)->get();
        $combo5= DB::table('tb_kelompok')->where('kelompok_id','NOT LIKE',$objekpajak->kelompok_id)->get();

        return view('objekpajak.detail', compact('objekpajak','cek1','cek2','cek3','cek4','cek5','combo1','combo2','combo3','combo4','combo5'));
   
    }
}
