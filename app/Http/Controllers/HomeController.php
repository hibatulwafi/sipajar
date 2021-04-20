<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth:login');
    } 

    public function index()
    {   $ops = DB::table ('tb_objek_pajak')
        ->get(); 
        $wp = DB::table ('tb_wajib_pajak')->count();
        $op = DB::table ('tb_objek_pajak')->count();
        $ad = DB::table ('tm_user_login')->where('user_role_id',3)->count();
        $pg = DB::table ('tb_penggunaan')->where('status_validasi',0)->count();
        $tg = DB::table ('tb_tagihan')->where('status_lunas',0)->count();
        $pt = DB::table ('tb_tagihan')->whereMonth('created_at', date('m',strtotime(now())))->sum('biaya_bayar');
        $log = DB::table ('tm_user_log')
               ->join('tm_user_login','tm_user_login.id','tm_user_log.user_id')
               ->orderBy('tm_user_log.id','DESC')->get();


        $data=array(
            'wp' => $wp,
            'op' =>$op,
            'ops' =>$ops,
            'pg' => $pg,
            'tg' => $tg,
            'ad' => $ad,
            'pt' => $pt,
            'log'=> $log
        );
        return view('home',$data);
    }

    public function simulasi()
    {
        $kriteria = DB::table ('tm_kriteria')->get();
        $hargabaku = DB::table ('tm_harga_baku')->get();
        $kelompok = DB::table ('tb_kelompok')->orderBy('kelompok_id','Desc')->get();
        $data=array(
            'combo1' => $kriteria,
            'combo2' => $hargabaku,
            'combo3' => $kelompok
        );
        return view('simulasi',$data);
    }

    public function simulasipost(Request $request){
        $opnama = $request->op_nama;
        $wpnama = $request->wp_nama;
        $kriteria_id = $request->kriteria_id;
        $harga_id = $request->harga_id;
        $kelompok_id = $request->kelompok_id;
        $meter = $request->meter;

        //cek parameter
        $cekkriteria = DB::table ('tm_kriteria')
                    ->where('kriteria_id',$kriteria_id)
                    ->first();
        $cekhargabaku = DB::table ('tm_harga_baku')
                    ->where('harga_id',$harga_id)
                    ->first();
        $cekkelompok = DB::table ('tb_kelompok')
                    ->where('kelompok_id',$kelompok_id)
                    ->first();
      
        // Menentukan Komponen SDA ( Bobot Kriteria * 60%)
        $kriteria = $cekkriteria->kriteria_bobot;
        $komponen_sda = $kriteria * 0.6;
        
        // Menentukan Nilai Indeks Komponen Peruntukan dan Pengelolaan
        $limapuluh = $cekkelompok->kelompok_limapuluh * 0.4;
        $limaratus = $cekkelompok->kelompok_limaratus * 0.4;
        $seribu = $cekkelompok->kelompok_seribu * 0.4;
        $duaribulima = $cekkelompok->kelompok_duaribulima * 0.4;
        $kelompok_lebih = $cekkelompok->kelompok_lebih * 0.4;
        
        // Menghitung Faktor Nilai Air (FNA)
        // FNA = ( 60% x Nilai Komponen Sumber Daya Alam) + (40% x Nilai   Komponen Peruntukan dan Pengelolaan)
        $fna1 = $komponen_sda + $limapuluh;
        $fna2 = $komponen_sda + $limaratus;
        $fna3 = $komponen_sda + $seribu;
        $fna4 = $komponen_sda + $duaribulima;
        $fna5 = $komponen_sda + $kelompok_lebih;

        // Menghitung Harga Dasar Air (HDA)
        // HDA = HAB x FNA
        $hab = $cekhargabaku->harga_nominal;
        
        $hda1 =  $hab *  $fna1;
        $hda2 =  $hab *  $fna2;
        $hda3 =  $hab *  $fna3;
        $hda4 =  $hab *  $fna4;
        $hda5 =  $hab *  $fna5;

        //Menghitung Nilai Perolehan Air
        //NPA = Volume Progresif x HAB x FNA
        $volume = $meter;
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
            'id' => "No. #INV.SAMPLE123456789",
            'wp' => $wpnama,
            'op_nama' => $opnama,
            'kelompok' => $cekkelompok->kelompok_nama,
            'kriteria' =>  $cekkriteria->kriteria_nama,
            'peringkat' =>  $cekkriteria->kriteria_peringkat,
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
            'total' =>  $total,
            'pajak' => $pajak,
        );
        return view ('simulasihitung',$data);
    }

    public function total_ram_cpu_usage()
{
        //RAM usage
        $free = shell_exec('free'); 
        $free = (string) trim($free);
        $free_arr = explode("\n", $free);
        $mem = explode(" ", $free_arr[1]);
        $mem = array_filter($mem);
        $mem = array_merge($mem);
        $usedmem = $mem[2];
        $usedmemInGB = number_format($usedmem / 1048576, 2) . ' GB';
        $memory1 = $mem[2] / $mem[1] * 100;
        $memory = round($memory1) . '%';
        $fh = fopen('/proc/meminfo', 'r');
        $mem = 0;
        while ($line = fgets($fh)) {
            $pieces = array();
            if (preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $pieces)) {
                $mem = $pieces[1];
                break;
            }
        }
        fclose($fh);
        $totalram = number_format($mem / 1048576, 2) . ' GB';
        
        //cpu usage
        $cpu_load = sys_getloadavg(); 
        $load = $cpu_load[0] . '% / 100%';
        
        return view('details',compact('memory','totalram','usedmemInGB','load'));
}
}
