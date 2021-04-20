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

class ApiServiceControllerSurveyor extends Controller
{
            function login(Request $request){
               
            $data = DB::table('tm_user_login')
                ->where('user_email', '=', $request->username)
                ->where('user_status','Aktif')
                ->where('user_role_id','4')
                ->select('id', 'user_first_name','user_email','user_password','user_last_name')
                ->first();
       
            if ($data){

                if ((Hash::check($request->password, $data->user_password))) {
                    $response["error"] = FALSE;
                    $response["success"] = "1";
                    $response["message"] = "Data Ditemukan";
                    $response["logindata"]["id"] = $data->id;
                    $response["logindata"]["user_email"] = $data->user_email;
                    $response["logindata"]["user_first_name"] = $data->user_first_name;
                    $response["logindata"]["user_last_name"] = $data->user_last_name;
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
                            'desc'  =>  $data->user_first_name." Melakukan Login"
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
            $nama_depan = $request->nama_depan;
            $nama_belakang = $request->nama_belakang;
            $password_old = $request->password_old;
            $password_new = $request->password_new;
            $repassword_new = $request->repassword_new;
                   
            $data = DB::table('tm_user_login')
                ->where('user_email', '=', $request->email)
                ->where('user_status','Aktif')
                ->where('user_role_id','4')
                ->select('id', 'user_kode','user_email','user_password')
                ->first();
       
            if ($data){

            if ((Hash::check($request->password_old, $data->user_password))) {
                if ($password_new != $repassword_new){
                    $response['success'] = "0";
                    $response['message'] = "Re Enter Password Tidak Sama";
                    echo json_encode($response);
                }else{

        
                    $qry= DB::table('tm_user_login')->where('user_email',$email)
                    ->update ([
                            'user_first_name' => $nama_depan,
                            'user_last_name' => $nama_belakang,
                            'user_password' =>  Hash::make($password_new), 
                            'updated_at' => now()
                         ]);
            
                    if ($qry) {
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

    function wajibpajak(){
        $data = DB::table('tb_wajib_pajak')->orderBy('wp_id','asc')->get();

        if (count ($data) > 0){
            $response["error"] = FALSE;
            $response["message"] = "Data Ditampilkan";
            foreach ($data as $dt){
                $response["wajibpajak"][]=array(
                    "wp_id" => $dt->wp_id,
                    "npwpd" => $dt->npwpd,
                    "nama" => $dt->nama,
                    "alamat" => $dt->alamat,
                    "tanggal_daftar" =>date('d M Y', strtotime($dt->tanggal_daftar)),
                    "email" =>$dt->email,
                    "telp" => $dt->telp,
                );
            } echo json_encode($response);
            } else {
                $response["error"] = TRUE;
                $response["error_msg"] = "Data Kosong";
                 $response["objekpajak"][]=array(
                    "wp_id" => "Data Kosong",
                    "npwpd" =>"Data Kosong",
                    "nama" => "Data Kosong",
                    "alamat" => "Data Kosong",
                    "tanggal_daftar" => "Data Kosong",
                    "email" => "Data Kosong",
                    "telp" => "Data Kosong",
                );
                echo json_encode($response);
            }
    }

    function cariwajibpajak(Request $request){
        $qry = $request->qry;
        $data = DB::table('tb_wajib_pajak')
        ->where('nama','ilike','%'.$qry.'%')
        ->orderBy('wp_id','asc')->get();

        if (count ($data) > 0){
            $response["error"] = FALSE;
            $response["message"] = "Data Ditampilkan";
            foreach ($data as $dt){
                $response["wajibpajak"][]=array(
                    "wp_id" => $dt->wp_id,
                    "npwpd" => $dt->npwpd,
                    "nama" => $dt->nama,
                    "alamat" => $dt->alamat,
                    "tanggal_daftar" =>date('d M Y', strtotime($dt->tanggal_daftar)),
                    "email" =>$dt->email,
                    "telp" => $dt->telp,
                );
            } echo json_encode($response);
            } else {
                $response["error"] = TRUE;
                $response["error_msg"] = "Data Kosong";
                echo json_encode($response);
            }
    }

    function detailwajibpajak(Request $request){
        $qry = $request->id;
        $data = DB::table('tb_wajib_pajak')->orderBy('wp_id','asc')
        ->where('tb_wajib_pajak.wp_id','like',"%".$qry."%")->get();

        if (count ($data) > 0){
            $response["error"] = FALSE;
            $response["message"] = "Data Ditampilkan";
            foreach ($data as $dt){
                $response["wajibpajak"][]=array(
                    "wp_id" => $dt->wp_id,
                    "npwpd" => $dt->npwpd,
                    "nama" => $dt->nama,
                    "alamat" => $dt->alamat,
                    "tanggal_daftar" =>date('d M Y', strtotime($dt->tanggal_daftar)),
                    "email" =>$dt->email,
                    "telp" => $dt->telp,
                );
            } echo json_encode($response);
            } else {
                $response["error"] = TRUE;
                $response["error_msg"] = "Data Kosong";
                 $response["objekpajak"][]=array(
                    "wp_id" => "Data Kosong",
                    "npwpd" =>"Data Kosong",
                    "nama" => "Data Kosong",
                    "alamat" => "Data Kosong",
                    "tanggal_daftar" => "Data Kosong",
                    "email" => "Data Kosong",
                    "telp" => "Data Kosong",
                );
                echo json_encode($response);
            }
    }

    function objekpajak(){
        $data = DB::table('tb_objek_pajak')->orderBy('op_id','asc')
        ->join('tb_wajib_pajak', 'tb_wajib_pajak.wp_id','tb_objek_pajak.wp_id')->get();

        if (count ($data) > 0){
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
                );
            } echo json_encode($response);
            } else {
                $response["error"] = TRUE;
                $response["error_msg"] = "Data Kosong";
                 $response["objekpajak"][]=array(
                    "op_id" => "Data Kosong",
                    "op_nama" =>"Data Kosong",
                    "nama_wajib_pajak" => "Data Kosong",
                    "op_alamat" => "Data Kosong",
                    "tanggal_registrasi" => "Data Kosong",
                    "nomor_ipat" => "Data Kosong",
                    "longitude" => "Data Kosong",
                    "latitude" => "Data Kosong",);
                echo json_encode($response);
            }
    }

    function detailobjekpajak(Request $request){
        $qry = $request->id;
        $data = DB::table('tb_objek_pajak')->orderBy('op_id','asc')
        ->join('tb_wajib_pajak', 'tb_wajib_pajak.wp_id','tb_objek_pajak.wp_id')
        ->where('tb_objek_pajak.wp_id','like',"%".$qry."%")->get();

        if (count ($data) > 0){
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
                );
            } echo json_encode($response);
            } else {
                $response["error"] = TRUE;
                $response["error_msg"] = "Data Kosong";
                 $response["objekpajak"][]=array(
                    "op_id" => "Data Kosong",
                    "op_nama" =>"Data Kosong",
                    "nama_wajib_pajak" => "Data Kosong",
                    "op_alamat" => "Data Kosong",
                    "longitude" => "Data Kosong",
                    "latitude" => "Data Kosong",);
                echo json_encode($response);
            }
    }

    function cariobjekpajak(Request $request){
        $qry = $request->id;
        $data = DB::table('tb_objek_pajak')->orderBy('op_id','asc')
        ->join('tb_wajib_pajak', 'tb_wajib_pajak.wp_id','tb_objek_pajak.wp_id')
        ->where('tb_objek_pajak.op_nama','ilike',"%".$qry."%")->get();

        if (count ($data) > 0){
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
                );
            } echo json_encode($response);
            } else {
                $response["error"] = TRUE;
                $response["error_msg"] = "Data Kosong";
                echo json_encode($response);
            }
    }

    function ceklaporan(){
    
        $data = DB::table('foto_penggunaan')->orderBy('foto_penggunaan.created_at','desc')
        ->join('tb_objek_pajak', 'foto_penggunaan.op_id','tb_objek_pajak.op_id')
        ->join('tb_wajib_pajak', 'tb_wajib_pajak.wp_id','tb_objek_pajak.wp_id')
        ->join('tb_penggunaan', 'tb_penggunaan.foto_id','foto_penggunaan.foto_id')
        ->where('foto_penggunaan.status_input',0)
        ->get();
        
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
    
                    $response["error"] = FALSE;
                    $response["message"] = "Data Ditampilkan";
                    $response["statuslaporan"][]=array(
                        "foto_id" => $dt->foto_id,
                        "nama" => $dt->foto_gambar,
                        "op_nama" => $dt->op_nama,
                        "op_alamat" => $dt->op_alamat,
                        "longitude" => $dt->longitude,
                        "latitude" => $dt->latitude,
                        "wp_nama" => $dt->nama,
                        "foto_bulan" => $dt->foto_bulan,
                        "foto_tahun" => $dt->foto_tahun,
                        "status" => $status,
                        "npa" => $dt->meter,
                    );
                  
                } 
                echo json_encode($response);
            } else {
                $response["error"] = TRUE;
                $response["error_msg"] = "Data Kosong";
                echo json_encode($response);
            }
    }

 function riwayatsurvey(Request $request){
    
        $data = DB::table('foto_penggunaan')->orderBy('foto_penggunaan.created_at','desc')
        ->join('tb_objek_pajak', 'foto_penggunaan.op_id','tb_objek_pajak.op_id')
        ->join('tb_wajib_pajak', 'tb_wajib_pajak.wp_id','tb_objek_pajak.wp_id')
        ->join('tb_penggunaan', 'tb_penggunaan.foto_id','foto_penggunaan.foto_id')
        ->where('foto_penggunaan.status_input','!=' ,0)
        ->where('tb_penggunaan.user_validasi',$request->id)
        ->get();
        
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
    
                    $response["error"] = FALSE;
                    $response["message"] = "Data Ditampilkan";
                    $response["statuslaporan"][]=array(
                        "foto_id" => $dt->foto_id,
                        "nama" => $dt->foto_gambar,
                        "op_nama" => $dt->op_nama,
                        "op_alamat" => $dt->op_alamat,
                        "longitude" => $dt->longitude,
                        "latitude" => $dt->latitude,
                        "wp_nama" => $dt->nama,
                        "foto_bulan" => $dt->foto_bulan,
                        "foto_tahun" => $dt->foto_tahun,
                        "status" => $status,
                        "npa" => $dt->meter,
                    );
                  
                } 
                echo json_encode($response);
            } else {
                $response["error"] = TRUE;
                $response["error_msg"] = "Data Kosong";
                echo json_encode($response);
            }
    }

    function detailstatuslaporan(Request $request){
        $qry = $request->id;

       $data = DB::table('foto_penggunaan')->orderBy('foto_penggunaan.created_at','desc')
        ->join('tb_objek_pajak', 'foto_penggunaan.op_id','tb_objek_pajak.op_id')
        ->join('tb_wajib_pajak', 'tb_wajib_pajak.wp_id','tb_objek_pajak.wp_id')
        ->join('tb_penggunaan', 'tb_penggunaan.foto_id','foto_penggunaan.foto_id')
        ->where('tb_objek_pajak.op_id',$qry)->get();

         
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
                    $response["error"] = FALSE;
                    $response["message"] = "Data Ditampilkan";
                    $response["statuslaporan"][]=array(
                        "nama" => $nama,
                        "foto_id" => $dt->foto_id,
                        "op_nama" => $dt->op_nama,
                        "foto_bulan" => $dt->foto_bulan,
                        "foto_tahun" => $dt->foto_tahun,
                        "status" => $status,
                        "npa" => $dt->meter,
                    );  }
                  
                    echo json_encode($response);
             
               
            } else {
                $response["error"] = TRUE;
                $response["error_msg"] = "Data Kosong";
		
                echo json_encode($response);
            }
    }

     function cekpassword(Request $request) {
        $email = $request->email;
        $hashcek = 'kotasukabumi';

        $data = DB::table('tm_user_login')
        ->where('user_email', '=', $request->email)
        ->where('user_status','Aktif')
        ->where('user_role_id','4')
        ->select('id','user_email','user_password')
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

    function validasi(Request $request){
        $foto_id = $request->foto_id;
        $meter = $request->meter;
        $status_validasi = $request->status_validasi;


         $qry= DB::table('tb_penggunaan')->where('foto_id', $foto_id)
        ->update ([
                'status_validasi' => $status_validasi,
                'meter' => $meter
            ]);
            $pesan="Data Berhasil diedit";

        if ($qry) {
            $response["error"] = FALSE;
            $response["success"] = "1";
            $response["message"] = "Berhasil Validasi";
            echo json_encode($response); 
        }else{
            $response["error"] = TRUE;
            $response["success"] = "0";
            $response["message"] = "Gagal Validasi";
            echo json_encode($response);
        }
        
    }

     function validasilaporan(Request $request){
        $foto_id = $request->foto_id;
        $meter = $request->meter;
        $user_validasi = $request->user_validasi;



        $qry= DB::table('tb_penggunaan')->where('foto_id',$foto_id)
        ->update ([
                'meter' => $meter,
                'status_validasi' => '2',
                'user_validasi' =>$user_validasi,
                'tgl_validasi'=>now(),
            ]);
        $qry2= DB::table('foto_penggunaan')->where('foto_id',$foto_id)
        ->update ([
                'status_input' => '2',
                
            ]);


    

           

        if ($qry) {

                $cek = DB::table('tm_user_login')
                ->where('id', '=', $user_validasi)
                ->select('user_first_name','user_last_name')
                ->first();

                $q=DB::table('tm_user_log')->select(DB::raw('MAX(id) as kd_max'));
                    if($q->count()>0){foreach($q->get() as $k){$id = $k->kd_max+1;}
                    }else{$id = "1";}
                    DB::table('tm_user_log')->insert([
                            'id' => $id,
                            'user_id' => $user_validasi,
                            'tanggal' => now(),
                            'alamat_ip' => $request->ip(),
                            'desc'  =>  $cek->user_first_name." ".$cek->user_last_name." Melakukan Validasi"
                    ]);


            $response["error"] = FALSE;
                $response['success'] = 1;
                $response['message'] = "Sukses, Terima Kasih";
                echo json_encode($response);
        }else{
            $response["error"] = TRUE;
                $response['success'] = 0;
                $response['message'] = "Gagal Validasi";
                echo json_encode($response);
        }
    }


 function uploadImage(Request $request) {
    
        $image = $request->image;
        $name = $request->name;
        $meter = $request->meter;
        $foto_id = $request->foto_id;
        $path = 'bukti/';
        $longitude = $request->longitude;
        $latitude = $request->latitude;
        $user_validasi = $request->user_validasi;
    
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

    
       $qry= DB::table('tb_penggunaan')->where('foto_id',$foto_id)
        ->update ([
                'meter' => $meter,
                'status_validasi' => '2',
                'user_validasi' =>$user_validasi,
                'tgl_validasi'=>now(),
                'updated_at' => now(),
            ]);

        $qry2= DB::table('foto_penggunaan')->where('foto_id',$foto_id)
        ->update ([
                'status_input' => '2',
                'foto_gambar' =>  $namerandom.".jpg",
                'longitude' => $longitude,
                'latitude' => $latitude,
                'foto_keterangan' => 'Validasi Ulang oleh Surveyor',
                'status_input' => 2,
                'updated_at' => now(),
                
            ]);
   
       
        
            if ($qry !== false) {

                $cek = DB::table('tm_user_login')
                ->where('id', '=', $user_validasi)
                ->select('user_first_name','user_last_name')
                ->first();

                    $q=DB::table('tm_user_log')->select(DB::raw('MAX(id) as kd_max'));
                    if($q->count()>0){foreach($q->get() as $k){$id = $k->kd_max+1;}
                    }else{$id = "1";}
                    DB::table('tm_user_log')->insert([
                            'id' => $id,
                            'user_id' => $user_validasi,
                            'tanggal' => now(),
                            'alamat_ip' => $request->ip(),
                            'desc'  =>  $cek->user_first_name." ".$cek->user_last_name." Upload Foto"
                    ]);

                $return = file_put_contents($path. $namerandom.".jpg",  $decodedImage1);
                $response['success'] = 1;
                $response['message'] = "Data Sudah Diupload";
                echo json_encode($response);
            } else {
                $response['success'] = 0;
                $response['message'] = "Uploaded Failed";
                echo json_encode($response);
            }
        
        
      
    }

     function log(Request $request){
       
        $wp_id = $request->id;



       $data = DB::table('tm_user_log')->orderBy('tanggal','desc')
        ->where('user_id', $wp_id)->get();

         
        if (count ($data) > 0){
            foreach ($data as $dt){
          
                    $response["error"] = FALSE;
                    $response['success'] = 1;
                    $response["message"] = "Data Ditampilkan";
                    $response["logdata"][]=array(
                        "id" => $dt->id,
                        "nama" => $dt->desc,
                        "tanggal" => date('d M Y - h:i:s', strtotime($dt->tanggal)),
                    );  }
                  
                    echo json_encode($response);
             
               
            } else {
                $response["error"] = TRUE;
                $response['success'] = 1;
                $response["error_msg"] = "Data Kosong";
                echo json_encode($response);
            }
        
    }

}
