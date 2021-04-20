<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use App\Penggunaan;

class TagihanController extends Controller
{
    public function index()
    {
        $qry = DB::table ('tb_tagihan')->orderBy('tb_tagihan.created_at','DESC')
        ->join('tb_penggunaan','tb_tagihan.pg_id','tb_penggunaan.pg_id')
        ->join('tb_objek_pajak','tb_objek_pajak.op_id','tb_penggunaan.op_id')
        ->join('tb_wajib_pajak','tb_wajib_pajak.wp_id','tb_objek_pajak.wp_id')
        ->select('tb_objek_pajak.op_nama','tb_objek_pajak.op_id','tb_wajib_pajak.nama',
                 'tb_penggunaan.bulan','tb_tagihan.pemakaian','tb_tagihan.biaya_bayar',
                 'tb_penggunaan.tahun','tb_tagihan.tarif','tb_tagihan.created_at',
                 'tb_tagihan.status_lunas','tb_tagihan.pg_id')
        ->get();

        $data=array(
            'qry' => $qry
        );
        return view ('tagihan.index',$data);
    }


    public function addtagihan(Request $request)
    {
      $id =  $request->id;
      $total = $request->total;
      $pajak = $request->pajak;
      $volume = $request->volume;
      $wp_id = $request->wp_id;
      $pg_id = $request->pg_id;
      
      $primary = 'tagihan_nomor';

        $q=DB::table('tb_tagihan')->select(DB::raw('MAX(RIGHT('.$primary.',5)) as kd_max'));
        $prx=date('dmY', strtotime(now()));
        if($q->count()>0)
        {
            foreach($q->get() as $k)
            {
                $tmp = ((int)$k->kd_max)+1;
                $kd = $prx.sprintf("%05s", $tmp);
            }
        }
        else
        {
            $kd = $prx."00001";
        }

            $qry = DB::table('tb_tagihan')->insert([
                'tagihan_nomor' => $kd,
                'pemakaian' => $volume,
                'denda' => 0,
                'status_lunas' => 0,
                'created_at' => now(),
                'biaya_bayar'  =>  $pajak,
                'tarif'  =>  $total,
                'dibuat_oleh' => Auth::guard('login')->user()->user_kode,
                'pg_id' =>$pg_id,
                'updated_at' => now(),
        
            ]);

         if ($qry) {
            session()->flash('success','Sukses  !');
            return redirect()->route('tagihan.index');
        }else{
            session()->flash('success','Gagal  !');
            return redirect()->route('laporan.index');
        }

    }

    public function detail(Request $request)
    {
        $qry = DB::table ('tb_objek_pajak')
        ->join('tb_wajib_pajak','tb_objek_pajak.wp_id','tb_wajib_pajak.wp_id')
        ->join('tb_kelompok','tb_objek_pajak.kelompok_id','tb_kelompok.kelompok_id')
        ->join('tm_kriteria','tb_objek_pajak.kriteria_id','tm_kriteria.kriteria_id')
        ->join('tm_harga_baku','tb_objek_pajak.harga_id','tm_harga_baku.harga_id')
        ->join('tb_penggunaan','tb_penggunaan.op_id','tb_objek_pajak.op_id')
        ->join('tb_tagihan','tb_tagihan.pg_id','tb_penggunaan.pg_id')
        ->where('tb_objek_pajak.op_id' , $request->id)
        ->first();

 
        $volume = $qry->pemakaian;
        // Menentukan Komponen SDA ( Bobot Kriteria * 60%)
        $kriteria = $qry->kriteria_bobot;
        $komponen_sda = $kriteria * 0.6;
        
        // Menentukan Nilai Indeks Komponen Peruntukan dan Pengelolaan
        $limapuluh = $qry->kelompok_limapuluh * 0.4;
        $limaratus = $qry->kelompok_limaratus * 0.4;
        $seribu = $qry->kelompok_seribu * 0.4;
        $duaribulima = $qry->kelompok_duaribulima * 0.4;
        $kelompok_lebih = $qry->kelompok_lebih * 0.4;
        
        // Menghitung Faktor Nilai Air (FNA)
        // FNA = ( 60% x Nilai Komponen Sumber Daya Alam) + (40% x Nilai   Komponen Peruntukan dan Pengelolaan)
        $fna1 = $komponen_sda + $limapuluh;
        $fna2 = $komponen_sda + $limaratus;
        $fna3 = $komponen_sda + $seribu;
        $fna4 = $komponen_sda + $duaribulima;
        $fna5 = $komponen_sda + $kelompok_lebih;

        // Menghitung Harga Dasar Air (HDA)
        // HDA = HAB x FNA
        $hab = $qry->harga_nominal;
        
        $hda1 =  $hab *  $fna1;
        $hda2 =  $hab *  $fna2;
        $hda3 =  $hab *  $fna3;
        $hda4 =  $hab *  $fna4;
        $hda5 =  $hab *  $fna5;

        //Menghitung Nilai Perolehan Air
        //NPA = Volume Progresif x HAB x FNA
        $nilai1 = 0; $nilai2 = 0; $nilai3 = 0; $nilai4 = 0; $nilai5 = 0;

        if ($volume <= 50){
            $nilai1 = $volume;
        } else if($volume <= 500){
            $nilai1 = 50;
            $nilai2 = $volume - $nilai1;
        } else if($volume <= 1000){
            $nilai1 = 50;
            $nilai2 = 450;
            $nilai3 = $volume - $nilai1 - $nilai2;
        } else if($volume <= 2500){
            $nilai1 = 50;
            $nilai2 = 450;
            $nilai3 = 500;
            $nilai4 = $volume - $nilai1 - $nilai2 - $nilai3;
        } else if($volume > 2500){
            $nilai1 = 50;
            $nilai2 = 450;
            $nilai3 = 500;
            $nilai4 = 1500;
            $nilai5 = $volume - $nilai1 - $nilai2 - $nilai3 - $nilai4;
        }

        $npa1 = $nilai1 * $hda1 ;
        $npa2 = $nilai2 * $hda2 ;
        $npa3 = $nilai3 * $hda3 ;
        $npa4 = $nilai4 * $hda4 ;
        $npa5 = $nilai5 * $hda5 ;
        $total = $npa1 + $npa2 + $npa3 + $npa4 + $npa5;
        $pajak = 0.2 * $total;
        $data=array(
            'id' => "No. #".$qry->op_id.date('dmY', strtotime(now())),
            'op_id' => $qry->op_id,
            'wp_id' => $qry->wp_id,
            'wp' => $qry->nama,
            'alamat' => $qry->alamat,
            'npwpd' => $qry->npwpd,
            'op_nama' => $qry->op_nama,
            'op_alamat' => $qry->op_alamat,
            'kelompok' => $qry->kelompok_nama,
            'kriteria' =>  $qry->kriteria_nama,
            'peringkat' =>  $qry->kriteria_peringkat,
            'bobot' =>  $kriteria,
            'nilai1' => $nilai1,
            'nilai2' => $nilai2,
            'nilai3' => $nilai3,
            'nilai4' => $nilai4,
            'nilai5' => $nilai5,
            'fna1' => $fna1,
            'fna2' => $fna2,
            'fna3' => $fna3,
            'fna4' => $fna4,
            'fna5' => $fna5,
            'npa1' => $npa1,
            'npa2' => $npa2,
            'npa3' => $npa3,
            'npa4' => $npa4,
            'npa5' => $npa5,
            'hda1' => $hda1,
            'hda2' => $hda2,
            'hda3' => $hda3,
            'hda4' => $hda4,
            'hda5' => $hda5,
            'hab' => $hab,
            'volume' => $volume,
            'total' =>  $qry->tarif,
            'pajak' => $qry->biaya_bayar,
            'pg_id'=>$request->pg_id,
        );

        return view ('tagihan.detail',$data);
    }

    function lunas(Request $request){
        $pg_id = $request->pg_id;

        $qry= DB::table('tb_tagihan')->where('pg_id', $pg_id)
        ->update ([
                'status_lunas' =>  1
        ]);
         return redirect()->route('tagihan.index');
    }
}
