<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\ObjekPajak;
use App\FotoPenggunaan;
use App\Penggunaan;
use App\Pesan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Hash;

class ApiServiceController extends Controller
{
   
        function login(Request $request){
               
            $data = DB::table('tm_user_login')
                ->where('user_email', '=', $request->username)
                ->where('user_status','Aktif')
                ->where('user_role_id','5')
                ->select('id', 'user_kode','user_email','user_password')
                ->first();
       
            if ($data){
                
                if ((Hash::check($request->password, $data->user_password))) {
                    $datawp=DB::table('tb_wajib_pajak')
                    ->where('wp_id',$data->user_kode)
                    ->first();
    
                    $response["error"] = FALSE;
                    $response["success"] = "1";
                    $response["message"] = "Data Ditemukan";
                    $response["logindata"]["tb_wp_id"] = $datawp->wp_id;
                    $response["logindata"]["tb_wp_nama"] = $datawp->nama;
                    $response["logindata"]["tb_wp_username"] = $data->user_email;
                    $response["logindata"]["tb_wp_npwpd"] = $datawp->npwpd;
                    $response["logindata"]["tb_wp_alamat"] = $datawp->alamat;
                    $response["logindata"]["tb_wp_tanggal_daftar"] = date('d M Y', strtotime($datawp->tanggal_daftar));
                    $response["logindata"]["tgl_sekarang"] = date('d', strtotime(now()));
                    $response["logindata"]["bulan_sekarang"] = date('m', strtotime(now()));
                    $response["logindata"]["tahun_sekarang"] = date('Y', strtotime(now()));
                    echo json_encode($response);

                    $q=DB::table('tm_user_log')->select(DB::raw('MAX(id) as kd_max'));
                        if($q->count()>0){foreach($q->get() as $k){$id = $k->kd_max+1;}
                        }else{$id = "1";}

                    

                     DB::table('tm_user_log')->insert([
                            'id' => $id,
                            'user_id' => $data->id,
                            'tanggal' => now(),
                            'alamat_ip' => $request->ip(),
                            'desc'  =>  $datawp->nama." Melakukan Login"
                        ]);

                }else{
                    $response["error"] = TRUE;
                    $response["success"] = "0";
                    $response["message"] = "Login Salah";
                    $response["logindata"][]=array();
                    echo json_encode($response); 
                }
                
            }else{
            
               $response["error"] = TRUE;
               $response["success"] = "0";
               $response["message"] = "Login Salah";
               $response["logindata"][]=array();
               echo json_encode($response);
       
            }
        }

        function editprofile(Request $request){
            $id = $request->id;
            $email = $request->email;
            $nama = $request->nama;
            $password_old = $request->password_old;
            $password_new = $request->password_new;
            $repassword_new = $request->repassword_new;
            $alamat = $request->alamat;
            
                   
            $data = DB::table('tm_user_login')
                ->where('user_email', '=', $request->email)
                ->where('user_status','Aktif')
                ->where('user_role_id','5')
                ->select('id', 'user_kode','user_email','user_password')
                ->first();
       
            if ($data){

            if ((Hash::check($request->password_old, $data->user_password))) {
                if ($password_new != $repassword_new){
                    $response['success'] = "0";
                    $response['message'] = "Re Enter Password Tidak Sama";
                    echo json_encode($response);
                }else{
                   
                    $qry1= DB::table('tb_wajib_pajak')->where('wp_id',$id)
                    ->update ([
                            'nama' => $nama,
                            'alamat' => $alamat,
                            //'email' => $email,
                            'updated_at' => now()
                        ]);
        
                    $qry2= DB::table('tm_user_login')->where('user_email',$email)
                    ->update ([
                            'user_first_name' => $nama,
                            'user_last_name' => " ",
                           // 'user_email' => $email,
                            'user_password' =>  Hash::make($password_new), 
                            'updated_at' => now()
                         ]);
            
                    if ($qry1 && $qry2) {
                        $response['success'] = "1";
                        $response['message'] = "Berhasil Update Profile";
                        echo json_encode($response);
                    }else{
                        $response['success'] = "0";
                        $response['message'] = "Gagal Update Profile";
                        echo json_encode($response);
                    }

                }
                
              
            }else{
                $response['success'] = "0";
                $response['message'] = "Password Lama Tidak Sama";
                echo json_encode($response);
            }
        }else{
            $response['success'] = "0";
            $response['message'] = "Email Tidak Valid";
            echo json_encode($response);
        }
        }

        function objekpajak(Request $request){
            $qry = $request->wp_id;
            $data = DB::table('tb_objek_pajak')->orderBy('op_id','asc')
            ->join('tb_wajib_pajak', 'tb_wajib_pajak.wp_id','tb_objek_pajak.wp_id')
            ->where('tb_wajib_pajak.wp_id','like',"%".$qry."%")->get();
    
            if ($data != null){
                $response["error"] = FALSE;
                $response["message"] = "Data Ditampilkan";
                foreach ($data as $dt){
                    $response["objekpajak"][]=array(
                        "op_id" => $dt->op_id,
                        "op_nama" => $dt->op_nama,
                        "nama_wajib_pajak" => $dt->nama,
                        "op_alamat" => $dt->op_alamat,
                        "tanggal_registrasi" =>date('d M Y', strtotime($dt->tanggal_registrasi)),
                        "nomor_ipat" =>$dt->nomor_ipat,
                        "longitude" => $dt->longitude,
                        "latitude" => $dt->latitude,
                        "status_meteran" => $dt->status_meteran,
                    );
                } echo json_encode($response);
                } else {
                    $response["error"] = TRUE;
                    $response["error_msg"] = "Data Kosong";
                    echo json_encode($response);
                }
        }

        function tagihanop(Request $request){
            $wp = $request->wp;
            $op = $request->op;
            $data = DB::table('tb_tagihan')->orderBy('tb_tagihan.created_at','asc')
            ->join('tb_penggunaan', 'tb_tagihan.pg_id','tb_penggunaan.pg_id')
            ->join('tb_objek_pajak', 'tb_penggunaan.op_id','tb_objek_pajak.op_id')
            ->join('tb_wajib_pajak', 'tb_wajib_pajak.wp_id','tb_objek_pajak.wp_id')
            ->select('tb_tagihan.tagihan_nomor','tb_objek_pajak.op_nama','tb_penggunaan.tahun','tb_penggunaan.bulan',
            'tb_wajib_pajak.nama','tb_tagihan.tarif','tb_tagihan.denda','tb_tagihan.biaya_bayar',
            'tb_tagihan.created_at','tb_tagihan.status_lunas','tb_objek_pajak.op_alamat','tb_tagihan.pemakaian')
            ->where('tb_wajib_pajak.wp_id',$wp)
            ->where('tb_objek_pajak.op_id',$op)
            ->get();
            

            if (count ($data) > 0){
                $response["error"] = FALSE;
                $response["message"] = "Data Ditampilkan";
                foreach ($data as $dt){
                if($dt->status_lunas == 0){
                 $status = 'Belum Lunas';
                }else{
                    $status = 'Lunas';
                }
                    $response["tagihan"][]=array(
                        "tg_id" => $dt->tagihan_nomor,
                        "op_nama" => $dt->op_nama,
                        //"tanggal" => cekbulan($dt->bulan).' '.$dt->tahun,
                        "bulan" => $dt->bulan,
                        "tahun" => $dt->tahun,
                        "nama_wajib_pajak" => $dt->nama,
                        "tarif" => number_format($dt->tarif),
                        "denda" => $dt->denda,
                        "total_tagihan" => number_format($dt->biaya_bayar,2,',','.'),
                        "alamat" => $dt->op_alamat,
                        "pemakaian" => $dt->pemakaian,
                        "status" => $status,
                    );
                } echo json_encode($response);
                } else {
                    $response["error"] = TRUE;
                    $response["error_msg"] = "Data Kosong";
                    echo json_encode($response);
                }
        }
    
    
        function tagihan(Request $rq){
            $data = DB::table('tb_tagihan')->orderBy('tb_tagihan.created_at','asc')
            ->join('tb_penggunaan', 'tb_tagihan.pg_id','tb_penggunaan.pg_id')
            ->join('tb_objek_pajak', 'tb_penggunaan.op_id','tb_objek_pajak.op_id')
            ->join('tb_wajib_pajak', 'tb_wajib_pajak.wp_id','tb_objek_pajak.wp_id')
            ->select('tb_tagihan.tagihan_nomor','tb_objek_pajak.op_nama','tb_penggunaan.tahun','tb_penggunaan.bulan',
            'tb_wajib_pajak.nama','tb_tagihan.tarif','tb_tagihan.denda','tb_tagihan.biaya_bayar',
            'tb_tagihan.created_at','tb_tagihan.status_lunas','tb_objek_pajak.op_alamat','tb_tagihan.pemakaian')
            ->where('tb_wajib_pajak.wp_id',$rq->id)->get();
            

            if (count ($data) > 0){
                $response["error"] = FALSE;
                $response["message"] = "Data Ditampilkan";
                foreach ($data as $dt){
                if($dt->status_lunas == 0){
                 $status = 'Belum Lunas';
                }else{
                    $status = 'Lunas';
                }
                    $response["tagihan"][]=array(
                        "tg_id" => $dt->tagihan_nomor,
                        "op_nama" => $dt->op_nama,
                        //"tanggal" => cekbulan($dt->bulan).' '.$dt->tahun,
                        "bulan" => $dt->bulan,
                        "tahun" => $dt->tahun,
                        "nama_wajib_pajak" => $dt->nama,
                        "tarif" => number_format($dt->tarif),
                        "denda" => $dt->denda,
                        "total_tagihan" => number_format($dt->biaya_bayar,2,',','.'),
                        "alamat" => $dt->op_alamat,
                        "pemakaian" => $dt->pemakaian,
                        "status" => $status,
                    );
                } echo json_encode($response);
                } else {
                    $response["error"] = TRUE;
                    $response["error_msg"] = "Data Kosong";
                    echo json_encode($response);
                }
        }
    
        function caritagihan(Request $request){
            $qry = $request->get('query');

            $data = DB::table('tb_tagihan')->orderBy('tb_tagihan.created_at','asc')
            ->join('tb_penggunaan', 'tb_tagihan.pg_id','tb_penggunaan.pg_id')
            ->join('tb_objek_pajak', 'tb_penggunaan.op_id','tb_objek_pajak.op_id')
            ->join('tb_wajib_pajak', 'tb_wajib_pajak.wp_id','tb_objek_pajak.wp_id')
            ->select('tb_tagihan.tagihan_nomor','tb_objek_pajak.op_nama','tb_penggunaan.tahun','tb_penggunaan.bulan',
            'tb_wajib_pajak.nama','tb_tagihan.tarif','tb_tagihan.denda','tb_tagihan.biaya_bayar',
            'tb_tagihan.created_at','tb_tagihan.status_lunas','tb_objek_pajak.op_alamat','tb_tagihan.pemakaian')
            ->where('tb_wajib_pajak.wp_id',$request->wp_id)
            ->where('tb_objek_pajak.op_nama','like','%'.$qry.'%')
            ->get();
            
            if (count ($data) > 0){
                $response["error"] = FALSE;
                $response["message"] = "Data Ditampilkan";
                foreach ($data as $dt){
                if($dt->status_lunas == 0){
                 $status = 'Belum Lunas';
                }else{
                    $status = 'Lunas';
                }
                    $response["tagihan"][]=array(
                        "tg_id" => $dt->tagihan_nomor,
                        "op_nama" => $dt->op_nama,
                        //"tanggal" => cekbulan($dt->bulan).' '.$dt->tahun,
                        "bulan" => $dt->bulan,
                        "tahun" => $dt->tahun,
                        "nama_wajib_pajak" => $dt->nama,
                        "tarif" => number_format($dt->tarif),
                        "denda" => $dt->denda,
                        "total_tagihan" => number_format($dt->biaya_bayar,2,',','.'),
                        "alamat" => $dt->op_alamat,
                        "pemakaian" => $dt->pemakaian,
                        "status" => $status,
                    );
                } echo json_encode($response);
                } else {
                    $response["error"] = TRUE;
                    $response["error_msg"] = "Data Kosong";
                    echo json_encode($response);
                }
        }
    
    function uploadImage(Request $request) {
    
        $image = $request->image;
        $name = $request->name;
        $op_id = $request->op_id;
        $path = 'bukti/';
        $longitude = $request->longitude;
        $latitude = $request->latitude;
        
    
        $randomid = mt_rand(10000,99999);

        $response = array();
        $decodedImage1 = base64_decode("$image");
        $namerandom = $name."-".$random = Str::random(10)."-".date('MY', strtotime(now()));
    	// $random = Str::random(5).date('MY', strtotime(now()));
        $random = Str::random(40);
        if (!file_exists($path)){
            mkdir($path,  0777, true);
        }else{
        }
    
        $bulan=date('m', strtotime(now()));
        if($bulan==12){
            $bulanpakai=1;
            $tahunpakai=(date('Y', strtotime(now())))-1;
        }else{
            $bulanpakai=$bulan - 1;
            $tahunpakai= date('Y', strtotime(now()));
        }
        
        $cekData=DB::table('foto_penggunaan')
            ->where([
                'op_id'=>$request->op_id,
                'foto_bulan' => $bulanpakai,
                'foto_tahun' => $tahunpakai,
                'status_input' => 0
            ])
            ->first();

        $cekData2=DB::table('foto_penggunaan')
            ->where([
                'op_id'=>$request->op_id,
                'foto_bulan' => $bulanpakai,
                'foto_tahun' => $tahunpakai,
                'status_input' => 2
            ])
            ->first();

        if($cekData){
                $response['success'] = 1;
                $response['message'] = "Anda Sudah Upload, Menunggu Review";
                echo json_encode($response);
        }elseif($cekData2){
                $response['success'] = 1;
                $response['message'] = "Anda Sudah Upload Bulan ini";
                echo json_encode($response);
        }else{
            $getWp=DB::table('tb_objek_pajak')->where('op_id',$request->op_id)->select('wp_id')->first();
            $data = DB::table('foto_penggunaan')->insert([
                'foto_id' => $randomid.date('m', strtotime(now())).$request->op_id,
                'foto_gambar' => $namerandom.".jpg",
                'path' => $path,
                'op_id' => $request->op_id,
                'foto_bulan'  =>  $bulanpakai,
                'foto_tahun'  =>  $tahunpakai,
                'created_at' => now(),
                'status_input' => 0,
                'longitude' => $longitude,
                'latitude' => $latitude,
        
            ]);
            $getId=Penggunaan::max('pg_id');
            $pg_id=$getId + 1;
            DB::table('tb_penggunaan')->insert([
                'pg_id' =>$pg_id,
                'op_id' => $request->op_id,
                'bulan' => $bulanpakai,
                'tahun' => $tahunpakai,
                'user_input' =>$getWp->wp_id,
                'created_at' => now(),
                'meter' =>0,
                'status_validasi' =>0,
                'foto_id' => $randomid.date('m', strtotime(now())).$request->op_id,
            ]);
        
            if ($data !== false) {
                $return = file_put_contents($path. $namerandom.".jpg",  $decodedImage1);
                $response['success'] = 1;
                $response['message'] = "Data Sudah Diupload, Mohon tunggu verifikasi admin jika ada perubahan";
                echo json_encode($response);
            } else {
                $response['success'] = 0;
                $response['message'] = "Uploaded Failed";
                echo json_encode($response);
            }
        }
        
        
      
    }

    function uploadImageDet(Request $request) {
    
        $image = $request->image;
        $name = $request->name;
        $op_id = $request->op_id;
        $path = 'bukti/';
        $longitude = $request->longitude;
        $latitude = $request->latitude;
        $meteran = $request->meteran;
        $keterangan =  $request->keterangan;
    
        $randomid = mt_rand(10000,99999);

        $response = array();
        $decodedImage1 = base64_decode("$image");
        $namerandom = $name."-".$random = Str::random(10)."-".date('MY', strtotime(now()));
    
        $random = Str::random(40);
        if (!file_exists($path)){
            mkdir($path,  0777, true);
        }else{
        }
    
        $bulan=date('m', strtotime(now()));
        if($bulan==12){
            $bulanpakai=1;
            $tahunpakai=(date('Y', strtotime(now())))-1;
        }else{
            $bulanpakai=$bulan - 1;
            $tahunpakai= date('Y', strtotime(now()));
        }
        
        $cekData=DB::table('foto_penggunaan')
            ->where([
                'op_id'=>$request->op_id,
                'foto_bulan' => $bulanpakai,
                'foto_tahun' => $tahunpakai,
                'status_input' => 0
            ])
            ->first();

        $cekData2=DB::table('foto_penggunaan')
            ->where([
                'op_id'=>$request->op_id,
                'foto_bulan' => $bulanpakai,
                'foto_tahun' => $tahunpakai,
                'status_input' => 2
            ])
            ->first();

        if($cekData){
                $response['success'] = 1;
                $response['message'] = "Anda Sudah Upload, Menunggu Review";
                echo json_encode($response);
        }elseif($cekData2){
                $response['success'] = 1;
                $response['message'] = "Anda Sudah Upload Bulan ini";
                echo json_encode($response);
        }else{
            $getWp=DB::table('tb_objek_pajak')->where('op_id',$request->op_id)->select('wp_id')->first();
            $data = DB::table('foto_penggunaan')->insert([
                'foto_id' => $randomid.date('m', strtotime(now())).$request->op_id,
                'foto_gambar' => $namerandom.".jpg",
                'path' => $path,
                'op_id' => $request->op_id,
                'foto_bulan'  =>  $bulanpakai,
                'foto_tahun'  =>  $tahunpakai,
                'created_at' => now(),
                'status_input' => 0,
                'longitude' => $longitude,
                'latitude' => $latitude,
                'foto_keterangan' => $keterangan,
        
            ]);
            $getId=Penggunaan::max('pg_id');
            $pg_id=$getId + 1;
            DB::table('tb_penggunaan')->insert([
                'pg_id' =>$pg_id,
                'op_id' => $request->op_id,
                'bulan' => $bulanpakai,
                'tahun' => $tahunpakai,
                'user_input' =>$getWp->wp_id,
                'created_at' => date('Y/m/d'),
                'meter' =>0,
                'status_validasi' =>0,
                'foto_id' => $randomid.date('m', strtotime(now())).$request->op_id,
                'meter' => $meteran,
            ]);
        
            if ($data !== false) {
                $return = file_put_contents($path. $namerandom.".jpg",  $decodedImage1);
                $response['success'] = 1;
                $response['message'] = "Data Sudah Diupload, Mohon tunggu verifikasi admin jika ada perubahan";
                echo json_encode($response);
            } else {
                $response['success'] = 0;
                $response['message'] = "Uploaded Failed";
                echo json_encode($response);
            }
        }
        
        
      
    }
    
    function statuslaporan(Request $request){
    
        $data = DB::table('foto_penggunaan')->orderBy('foto_penggunaan.created_at','desc')
        ->join('tb_objek_pajak', 'foto_penggunaan.op_id','tb_objek_pajak.op_id')
        ->join('tb_wajib_pajak', 'tb_wajib_pajak.wp_id','tb_objek_pajak.wp_id')
        ->join('tb_penggunaan', 'tb_penggunaan.foto_id','foto_penggunaan.foto_id')
        ->where('tb_wajib_pajak.wp_id',$request->wp_id)->get();
        
        if (count ($data) > 0){
           
            foreach ($data as $dt){
            if($dt->status_input == 0){
            $status = 'Sedang Proses';
            }elseif($dt->status_input == 1){
            $status = 'Ditolak';
            }elseif($dt->status_input == 2){
            $status = 'Diterima';
            }else{
            $status = 'Error';   
            }
    
            $nama= $dt->foto_gambar;
    
                    
                    $response["statuslaporan"][]=array(
                        "nama" => $nama,
                        "foto_id" => $dt->foto_id,
                        "op_nama" => $dt->op_nama,
                        "foto_bulan" => $dt->foto_bulan,
                        "foto_tahun" => $dt->foto_tahun,
                        "status" => $status,
                        "npa" => $dt->meter,
                    );
                  
                } 
                $response["error"] = FALSE;
                $response["message"] = "Data Ditampilkan";
                echo json_encode($response);
            } else {
                $response["error"] = TRUE;
                $response["error_msg"] = "Data Kosong";
                echo json_encode($response);
            }
    }


    function caristatuslaporan(Request $request){


       $qry = $request->get('query');
       $data = DB::table('foto_penggunaan')->orderBy('foto_penggunaan.created_at','desc')
        ->join('tb_objek_pajak', 'foto_penggunaan.op_id','tb_objek_pajak.op_id')
        ->join('tb_wajib_pajak', 'tb_wajib_pajak.wp_id','tb_objek_pajak.wp_id')
        ->join('tb_penggunaan', 'tb_penggunaan.foto_id','foto_penggunaan.foto_id')
        ->where('tb_wajib_pajak.wp_id',$request->wp_id)
        ->where('tb_objek_pajak.op_nama','like','%'.$qry.'%')->get();

         
        if (count ($data) > 0){
            foreach ($data as $dt){
            if($dt->status_input == 0){
            $status = 'Sedang Proses';
            }elseif($dt->status_input == 1){
            $status = 'Ditolak';
            }elseif($dt->status_input == 2){
            $status = 'Diterima';
            }else{
            $status = 'Error';   
            }
    
            $nama= $dt->foto_gambar;
                    $response["statuslaporan"][]=array(
                        "nama" => $nama,
                        "foto_id" => $dt->foto_id,
                        "op_nama" => $dt->op_nama,
                        "foto_bulan" => $dt->foto_bulan,
                        "foto_tahun" => $dt->foto_tahun,
                        "status" => $status,
                        "npa" => $dt->meter,
                    );  }
                    $response["error"] = FALSE;
                    $response["message"] = "Data Ditampilkan";
                    echo json_encode($response);
             
               
            } else {
                $response["error"] = TRUE;
                $response["error_msg"] = "Data Kosong";
		
                echo json_encode($response);
            }
    }

    function kirimpesan(Request $request) {
    
        $pesan_isi = $request->pesan_isi;
        $pesan_subjek = $request->pesan_subjek;
        $pengirim = $request->pengirim;
        $penerima = $request->penerima;
        
    
            $data = DB::table('tb_pesan')->insert([
                'pesan_isi' => $pesan_isi,
                'pesan_subjek' =>   $pesan_subjek,
                'pengirim' =>  $pengirim,
                'penerima'  =>  0,
                'tanggal' => now(),
                'status' => 1,
        
            ]);

            if ($data !== false) {
                $response["error"] = FALSE;
                $response['success'] = 1;
                $response['message'] = "Pesan Sudah Terkirim";
                echo json_encode($response);
            } else {
                $response["error"] = TRUE;
                $response['success'] = 0;
                $response['message'] = "Gagal Kirim Pesan";
                echo json_encode($response);
            }
    }

    function pesanmasuk(Request $request) {
        $data = DB::table('tb_pesan')->orderBy('tb_pesan.tanggal','desc')
        ->join('tm_user_login', 'tm_user_login.user_kode','tb_pesan.pengirim')
        ->where('tb_pesan.status',1)
        ->where('tb_pesan.penerima',$request->id)->get();
        
        if (count ($data) > 0){
            $response["error"] = FALSE;
            $response["message"] = "Data Ditampilkan";
            foreach ($data as $dt){
                    $response["pesan"][]=array(
                        "pesan_id" => $dt->pesan_id,
                        "pesan_subjek" => $dt->pesan_subjek,
                        "pesan_isi" => $dt->pesan_isi,
                        "id_pengirim" => $dt->pengirim,
                        "pengirim" =>   $dt->user_first_name." ".$dt->user_last_name ,
                        "penerima" => $dt->penerima,
                        "tanggal" => date('d M Y', strtotime($dt->tanggal)),
                        "status" => $dt->status,
                    );}
                    echo json_encode($response);
             
            } else {
                $response["error"] = TRUE;
                $response["error_msg"] = "Data Kosong";
                echo json_encode($response);
            }
    }

    function caripesan(Request $request){
        $qry = $request->get('query');

        $data = DB::table('tb_pesan')
        ->join('tm_user_login', 'tm_user_login.user_kode','tb_pesan.pengirim')
        ->where('pesan_subjek','ilike','%'.$qry.'%')
        ->where('penerima','like','%'.$request->get('wp_id').'%')
        ->get();

        if (count ($data) > 0) {
            $response["error"] = FALSE;
            $response["message"] = "Data Ditampilkan";
            foreach ($data as $dt){
                    $response["pesan"][]=array(
                        "pesan_id" => $dt->pesan_id,
                        "pesan_isi" => $dt->pesan_isi,
                        "pesan_subjek" => $dt->pesan_subjek,
                        "id_pengirim" => $dt->pengirim,
                        "pengirim" =>   $dt->user_first_name." ".$dt->user_last_name ,
                        "penerima" => $dt->penerima,
                        "tanggal" => date('d M Y', strtotime($dt->tanggal)),
                        "status" => $dt->status,
                    );}
                    echo json_encode($response);
        }else{
            $response["error"] = TRUE;
            $response["error_msg"] = "Data Kosong";
            echo json_encode($response);
        }
    }

    function caripesankeluar(Request $request){
        $qry = $request->get('query');

        $data = DB::table('tb_pesan')
        ->join('tm_user_login', 'tm_user_login.user_kode','tb_pesan.pengirim')
        ->where('pesan_subjek','ilike','%'.$qry.'%')
        ->where('pengirim','like','%'.$request->get('wp_id').'%')
        ->get();

        if (count ($data) > 0) {
            $response["error"] = FALSE;
            $response["message"] = "Data Ditampilkan";
            foreach ($data as $dt){
                    $response["pesan"][]=array(
                        "pesan_id" => $dt->pesan_id,
                        "pesan_isi" => $dt->pesan_isi,
                        "pesan_subjek" => $dt->pesan_subjek,
                        "id_pengirim" => $dt->pengirim,
                        "pengirim" =>   $dt->user_first_name." ".$dt->user_last_name ,
                        "penerima" => $dt->penerima,
                        "tanggal" => date('d M Y', strtotime($dt->tanggal)),
                        "status" => $dt->status,
                    );}
                    echo json_encode($response);
        }else{
            $response["error"] = TRUE;
            $response["error_msg"] = "Data Kosong";
            echo json_encode($response);
        }
    }

    function pesankeluar(Request $request) {
        $data = DB::table('tb_pesan')->orderBy('tb_pesan.tanggal','desc')
        ->join('tm_user_login', 'tm_user_login.user_kode','tb_pesan.pengirim')
        ->where('tb_pesan.status',1)
        ->where('tb_pesan.pengirim',$request->id)->get();
        
        if (count ($data) > 0){
            $response["error"] = FALSE;
            $response["message"] = "Data Ditampilkan";
            foreach ($data as $dt){
                    $response["pesan"][]=array(
                        "pesan_id" => $dt->pesan_id,
                        "pesan_subjek" => $dt->pesan_subjek,
                        "pesan_isi" => $dt->pesan_isi,
                        "id_pengirim" => $dt->pengirim,
                        "pengirim" =>   $dt->user_first_name." ".$dt->user_last_name ,
                        "penerima" => $dt->penerima,
                        "tanggal" => date('d M Y', strtotime($dt->tanggal)),
                        "status" => $dt->status,
                    );}
                    echo json_encode($response);
             
            } else {
                $response["error"] = TRUE;
                $response["error_msg"] = "Data Kosong";
                echo json_encode($response);
            }
    }

    function kirimpesankeluar(Request $request) {
    
        $pesan_isi = $request->pesan_isi;
        $pesan_subjek = $request->pesan_subjek;
        $pengirim = $request->pengirim;
    
            $data = DB::table('tb_pesan')->insert([
                'pesan_isi' => $pesan_isi,
                'pesan_subjek' =>   $pesan_subjek,
                'pengirim' =>  $pengirim,
                'penerima'  =>  0,
                'tanggal' => now(),
                'status' => 1,
        
            ]);

            if ($data !== false) {
                $response["error"] = FALSE;
                $response['success'] = 1;
                $response['message'] = "Pesan Sudah Terkirim";
                echo json_encode($response);
            } else {
                $response["error"] = TRUE;
                $response['success'] = 0;
                $response['message'] = "Gagal Kirim Pesan";
                echo json_encode($response);
            }
    }

    
    function cekpassword(Request $request) {
        $email = $request->email;
        $hashcek = 'kotasukabumi';

        $data = DB::table('tm_user_login')
        ->where('user_email', '=', $request->email)
        ->where('user_status','Aktif')
        ->where('user_role_id','5')
        ->select('id', 'user_kode','user_email','user_password')
        ->first();

    if ($data){ 
        
        if ((Hash::check($hashcek, $data->user_password))) {
            $response["error"] = TRUE;
            $response["success"] = "0";
            $response["message"] = "Password masi default, harap ganti untuk keamanan";
            echo json_encode($response);
        }else{
            $response["error"] = FALSE;
            $response["success"] = "1";
            $response["message"] = "Password sudah di ganti";
            echo json_encode($response); 
        }
        
    }else{
    
       $response["error"] = TRUE;
       $response["success"] = "0";
       $response["message"] = "Email tidak tersedia";
       echo json_encode($response);

    }

    }
}