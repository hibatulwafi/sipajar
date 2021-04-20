<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use App\Penggunaan;

class LaporanController extends Controller
{
    public function index()
    {   
        $bulan=date('m', strtotime(now()));
        if($bulan==12){
            $bulanpakai=1;
            $tahunpakai=(date('Y', strtotime(now())))-1;
        }else{
            $bulanpakai=$bulan - 1;
            $tahunpakai= date('Y', strtotime(now()));
        }

        $qry = DB::table ('foto_penggunaan')->orderBy('tb_penggunaan.created_at','Desc')
        ->join('tb_penggunaan','foto_penggunaan.foto_id','tb_penggunaan.foto_id')
        ->join('tb_objek_pajak','tb_objek_pajak.op_id','tb_penggunaan.op_id')
        ->join('tb_wajib_pajak','tb_wajib_pajak.wp_id','tb_objek_pajak.wp_id')
        /*->where('tb_penggunaan.bulan',$bulanpakai)
        ->where('tb_penggunaan.tahun',$tahunpakai)*/

        ->select('foto_penggunaan.longitude as flong','foto_penggunaan.latitude as flat',
                  'tb_objek_pajak.longitude as oplong','tb_objek_pajak.latitude as oplat',
                  'tb_objek_pajak.op_nama','tb_wajib_pajak.nama','foto_penggunaan.foto_bulan',
                  'foto_penggunaan.foto_tahun','tb_penggunaan.meter','tb_penggunaan.status_validasi',
                  'tb_penggunaan.created_at','foto_penggunaan.foto_id','foto_penggunaan.path',
                  'foto_penggunaan.foto_gambar','foto_penggunaan.status_input')
        ->get();

        $data=array(
            'qry' => $qry
        );
        return view ('laporan.index',$data);
    }

    public function nonmeter()
    {  
        $bulan=date('m', strtotime(now()));
        if($bulan==1){
            $bulanpakai=12;
            $tahunpakai=(date('Y', strtotime(now())))-1;
        }else{
            $bulanpakai=$bulan - 1;
            $tahunpakai= date('Y', strtotime(now()));
        }


        $qry = DB::table ('tb_objek_pajak')
        ->join('tb_wajib_pajak','tb_wajib_pajak.wp_id','tb_objek_pajak.wp_id')
        ->join('tb_penggunaan','tb_penggunaan.op_id','tb_objek_pajak.op_id')
        ->where('tb_objek_pajak.status_meteran',0)
        ->where('tb_penggunaan.bulan', $bulanpakai)
        ->select('tb_objek_pajak.op_id')->get();

        if(count($qry) <= 0){
            $data1 = DB::table ('tb_objek_pajak')
            ->join('tb_wajib_pajak','tb_wajib_pajak.wp_id','tb_objek_pajak.wp_id')
            ->where('tb_objek_pajak.status_meteran',0)
            ->select('tb_objek_pajak.op_id' ,'tb_wajib_pajak.nama', 'tb_objek_pajak.op_nama','tb_objek_pajak.mesin_merk',
                    'tb_objek_pajak.kapasitas_minimal','tb_objek_pajak.kapasitas_maksimal')->get();
        }else{
            foreach ($qry as $hasil) {
                $data[] = $hasil->op_id;
            } 
            $data1 = DB::table ('tb_objek_pajak')
            ->join('tb_wajib_pajak','tb_wajib_pajak.wp_id','tb_objek_pajak.wp_id')
            ->where('tb_objek_pajak.status_meteran',0)
            ->whereNotIn('tb_objek_pajak.op_id',$data)
            ->select('tb_objek_pajak.op_id' ,'tb_wajib_pajak.nama', 'tb_objek_pajak.op_nama','tb_objek_pajak.mesin_merk',
                    'tb_objek_pajak.kapasitas_minimal','tb_objek_pajak.kapasitas_maksimal')->get();
        }
            

      

        $data=array(
            'qry' => $data1,
        );
        return view ('laporan.nonmeter',$data);
    }

    public function belumlapor(){
         $bulan=date('m', strtotime(now()));
        if($bulan==1){
            $bulanpakai=12;
            $tahunpakai=(date('Y', strtotime(now())))-1;
        }else{
            $bulanpakai=$bulan - 1;
            $tahunpakai= date('Y', strtotime(now()));
        }


        $qry = DB::table ('tb_objek_pajak')
        ->join('tb_wajib_pajak','tb_wajib_pajak.wp_id','tb_objek_pajak.wp_id')
        ->join('tb_penggunaan','tb_penggunaan.op_id','tb_objek_pajak.op_id')
        ->where('tb_objek_pajak.status_meteran',1)
        ->where('tb_penggunaan.bulan', $bulanpakai)
        ->select('tb_objek_pajak.op_id')->get();

        if(count($qry) <= 0){
            $data1 = DB::table ('tb_objek_pajak')
            ->join('tb_wajib_pajak','tb_wajib_pajak.wp_id','tb_objek_pajak.wp_id')
            ->join('tb_penggunaan','tb_penggunaan.op_id','tb_objek_pajak.op_id')
            ->where('tb_objek_pajak.status_meteran',1)
            ->select('tb_objek_pajak.op_id' ,'tb_wajib_pajak.nama', 'tb_objek_pajak.op_nama','tb_objek_pajak.mesin_merk',
                    'tb_objek_pajak.kapasitas_minimal','tb_objek_pajak.kapasitas_maksimal')->get();
        }else{
            foreach ($qry as $hasil) {
                $data[] = $hasil->op_id;
            } 
            $data1 = DB::table ('tb_objek_pajak')
            ->join('tb_wajib_pajak','tb_wajib_pajak.wp_id','tb_objek_pajak.wp_id')
            ->where('tb_objek_pajak.status_meteran',1)
            ->whereNotIn('tb_objek_pajak.op_id',$data)
            ->select('tb_objek_pajak.op_id' ,'tb_wajib_pajak.nama', 'tb_objek_pajak.op_nama','tb_objek_pajak.mesin_merk',
                    'tb_objek_pajak.kapasitas_minimal','tb_objek_pajak.kapasitas_maksimal')->get();
        }

        $data=array(
            'qry' => $data1,
        );
        return view ('laporan.belumlapor',$data);
    }
    public function hitung(Request $request)
    {
        $cek=DB::table('foto_penggunaan')
        ->where('foto_id' , $request->id)
        ->first();

        $cekOP=DB::table('tb_objek_pajak')
        ->where('op_id' , $cek->op_id)
        ->first();

        $qry = DB::table ('foto_penggunaan')
        ->join('tb_penggunaan','foto_penggunaan.foto_id','tb_penggunaan.foto_id')
        ->join('tb_objek_pajak','tb_penggunaan.op_id','tb_objek_pajak.op_id')
        ->join('tb_wajib_pajak','tb_objek_pajak.wp_id','tb_wajib_pajak.wp_id')
        ->join('tb_kelompok','tb_objek_pajak.kelompok_id','tb_kelompok.kelompok_id')
        ->join('tm_kriteria','tb_objek_pajak.kriteria_id','tm_kriteria.kriteria_id')
        ->join('tm_harga_baku','tb_objek_pajak.harga_id','tm_harga_baku.harga_id')
        ->where('foto_penggunaan.foto_id' , $request->id)
        ->select('foto_penggunaan.longitude as flong','foto_penggunaan.latitude as flat',
                  'tb_objek_pajak.longitude as oplong','tb_objek_pajak.latitude as oplat',
                  'tb_objek_pajak.op_nama','tb_wajib_pajak.nama','foto_penggunaan.foto_bulan',
                  'foto_penggunaan.foto_tahun','tb_penggunaan.meter','tb_penggunaan.status_validasi',
                  'tb_penggunaan.created_at','foto_penggunaan.foto_id','foto_penggunaan.path',
                  'foto_penggunaan.foto_gambar','tb_objek_pajak.op_id','tm_kriteria.kriteria_bobot',
                  'tb_kelompok.kelompok_limapuluh','tb_kelompok.kelompok_limaratus','tb_kelompok.kelompok_seribu',
                  'tb_kelompok.kelompok_duaribulima','tb_kelompok.kelompok_lebih','tm_harga_baku.harga_nominal',
                  'tb_wajib_pajak.alamat','tb_wajib_pajak.npwpd','tb_wajib_pajak.nama','tb_objek_pajak.op_alamat',
                  'tb_kelompok.kelompok_nama','tm_kriteria.kriteria_nama','tm_kriteria.kriteria_peringkat',
                  'tb_penggunaan.pg_id','tb_wajib_pajak.wp_id'
                  )
        ->first();

        $bulan=date('m', strtotime(now()));
        if($bulan==1){
            $bulanpakai=11;
            $tahunpakai=(date('Y', strtotime(now())))-1;
        }else if($bulan==2){
            $bulanpakai=12;
            $tahunpakai=(date('Y', strtotime(now())))-1;
        }else{
            $bulanpakai=$bulan - 2;
            $tahunpakai= date('Y', strtotime(now()));
        }

        $cekmetersebelum = DB::table ('foto_penggunaan')->orderBy('tb_penggunaan.created_at','Desc')
        ->join('tb_penggunaan','foto_penggunaan.foto_id','tb_penggunaan.foto_id')
        ->join('tb_objek_pajak','tb_objek_pajak.op_id','tb_penggunaan.op_id')
        ->join('tb_wajib_pajak','tb_wajib_pajak.wp_id','tb_objek_pajak.wp_id')
        ->where('tb_penggunaan.bulan','<=' ,$bulanpakai)
        ->where('tb_penggunaan.tahun',$tahunpakai)
        ->where('tb_penggunaan.op_id',$qry->op_id)
        ->select('tb_penggunaan.meter')
        ->first();
        
        if($cekmetersebelum != null){
            $volumesebelum = $cekmetersebelum->meter;
        }else{
             $volumesebelum = 0;
        }
        
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
        $volume = $qry->meter - $volumesebelum;
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
            'id' => "No. #INV.".$qry->pg_id."/".$qry->wp_id."/".date('dmY', strtotime(now())),
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
            'total' =>  $total,
            'pajak' => $pajak,
            'flong' => $qry->flong,
            'flat' => $qry->flat,
            'oplong' => $qry->oplong,
            'oplat' => $qry->oplat,
            'pg_id' => $qry->pg_id,
            'op_id' => $qry->op_id,
            'wp_id' => $qry->wp_id,
        );

        return view ('laporan.hitung',$data);
    }

    public function hitungtanpameter(Request $request)
    {
        

        $qry = DB::table ('tb_objek_pajak')
        ->join('tb_wajib_pajak','tb_objek_pajak.wp_id','tb_wajib_pajak.wp_id')
        ->join('tb_kelompok','tb_objek_pajak.kelompok_id','tb_kelompok.kelompok_id')
        ->join('tm_kriteria','tb_objek_pajak.kriteria_id','tm_kriteria.kriteria_id')
        ->join('tm_harga_baku','tb_objek_pajak.harga_id','tm_harga_baku.harga_id')
        ->where('op_id' , $request->id)
        ->where('status_meteran' , 0)
        ->first();

        
        $Qmin = $qry->kapasitas_minimal;
        $Qmaks = $qry->kapasitas_maksimal;
        $Qr = (($Qmin + $Qmaks) / 2)/1000 * 60;
        $volume = $Qr * 8 * 30;

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
            'total' =>  $total,
            'pajak' => $pajak,
        );

        return view ('laporan.generate',$data);
    }

    public function nmtagihan(Request $request)
    {
      $id =  $request->id;
      $total = $request->total;
      $pajak = $request->pajak;
      $volume = $request->volume;
      $wp_id = $request->wp_id;

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


        $bulan=date('m', strtotime(now()));
        if($bulan==1){
            $bulanpakai=12;
            $tahunpakai=(date('Y', strtotime(now())))-1;
        }else{
            $bulanpakai=$bulan - 1;
            $tahunpakai= date('Y', strtotime(now()));
        }

            $cekData=DB::table('tb_penggunaan')
            ->where([
                'op_id'=>$id,
                'bulan' => $bulanpakai,
                'tahun' => $tahunpakai,
                'status_validasi' => 2
            ])
            ->first();


        if($cekData){
               /* $response['success'] = 1;
                $response['message'] = "Sudah Generate";
                echo json_encode($response);
*/
            session()->flash('success','Gagal  Sudah Generate!');
            return redirect()->route('laporan.nonmeter');
        }else{
            $getId=Penggunaan::max('pg_id');
            $pg_id=$getId + 1;
            $qry =  DB::table('tb_penggunaan')->insert([
                'pg_id' =>$pg_id,
                'op_id' => $id,
                'meter' =>  $volume,
                'created_at' => now(),
                'bulan' => $bulanpakai,
                'tahun' => $tahunpakai,
                'user_input' =>$wp_id,
                'status_validasi' =>2,
                'tgl_validasi' => date('Y-m-d'),
                'user_validasi' => Auth::guard('login')->user()->user_kode,
                'user_input' => Auth::guard('login')->user()->user_kode,
            ]);


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
            return redirect()->route('laporan.nonmeter');
        }
        }

      
       
    }

    public function tolak(Request $request){

        $qry= DB::table('tb_penggunaan')->where('foto_id',$request->id)
        ->update ([
                'status_validasi' => '1',

            ]);
        $qry2= DB::table('foto_penggunaan')->where('foto_id',$request->id)
        ->update ([
                'status_input' => '1',
                
            ]);
            $pesan="Data Berhasil diedit";

        if ($qry) {
            session()->flash('success','Sukses ubah data !');
            return redirect()->route('laporan.index');
        }else{
            session()->flash('success','Gagal ubah data !');
            return redirect()->route('laporan.index');
        }
       
    }

    public function terima(Request $request){

        $qry= DB::table('tb_penggunaan')->where('foto_id',$request->foto_id)
        ->update ([
                'status_validasi' => '2',
                'meter' => $request->meter
            ]);
        $qry2= DB::table('foto_penggunaan')->where('foto_id',$request->foto_id)
        ->update ([
                'status_input' => '2',
                
            ]);
            $pesan="Data Berhasil diedit";

        if ($qry) {
            session()->flash('success','Sukses ubah data !');
            return redirect()->route('laporan.hitung', ['id' => $request->foto_id]);
        }else{
            session()->flash('success','Gagal ubah data !');
            return redirect()->route('laporan.index');
        }
        
       
    }

}
