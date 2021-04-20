<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\ObjekPajak;
use App\FotoPenggunaan;
use App\Penggunaan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApiServiceController2 extends Controller
{
    function login(Request $request){
        $username = $request->username;
        $password = $request->password;
   
        $data = DB::table('tb_wajib_pajak')
        ->where('tb_wajib_pajak.username',$username)
        ->where('tb_wajib_pajak.password',$password)
        ->first();
   
        if ($data){
            $response["error"] = FALSE;
            $response["success"] = "1";
            $response["message"] = "Data Ditemukan";
            $response["logindata"]["tb_wp_id"] = $data->wp_id;
            $response["logindata"]["tb_wp_nama"] = $data->nama;
            $response["logindata"]["tb_wp_username"] = $data->username;
            $response["logindata"]["tb_wp_npwpd"] = $data->npwpd;
            $response["logindata"]["tb_wp_alamat"] = $data->alamat;
            $response["logindata"]["tb_wp_tanggal_daftar"] = date('d M Y', strtotime($data->tanggal_daftar));
            $response["logindata"]["tgl_sekarang"] = date('d', strtotime(now()));
            $response["logindata"]["bulan_sekarang"] = date('m', strtotime(now()));
            $response["logindata"]["tahun_sekarang"] = date('Y', strtotime(now()));

            echo json_encode($response);
        }else{
           $response["error"] = TRUE;
           $response["success"] = "0";
           $response["message"] = "Login Salah";
           $response["logindata"][]=array();
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
                    "longitude" => $dt->longitude,
                    "latitude" => $dt->latitude,
                );
            } echo json_encode($response);
            } else {
                $response["error"] = TRUE;
                $response[error_msg] = "Data Kosong";
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

    function tagihan($id){
        $data = DB::table('tb_tagihan')->orderBy('tb_tagihan.dibuat_pada','asc')
        ->join('tb_penggunaan', 'tb_tagihan.pg_id','tb_penggunaan.pg_id')
        ->join('tb_objek_pajak', 'tb_penggunaan.op_id','tb_objek_pajak.op_id')
        ->join('tb_wajib_pajak', 'tb_wajib_pajak.wp_id','tb_objek_pajak.wp_id')
        ->select('tb_tagihan.tg_id','tb_objek_pajak.op_nama','tb_tagihan.tanggal',
        'tb_wajib_pajak.nama','tb_tagihan.tarif','tb_tagihan.denda','tb_tagihan.pajak_air_tanah',
        'tb_tagihan.dibuat_pada','tb_tagihan.status_lunas','tb_objek_pajak.op_alamat','tb_tagihan.pemakaian')
        ->where('tb_wajib_pajak.wp_id','like',"%".$id."%")->get();
        
        if ($data !== null){
            $response["error"] = FALSE;
            $response["message"] = "Data Ditampilkan";
            foreach ($data as $dt){
            if($dt->status_lunas == 0){
            $status = 'Belum Lunas';
            }else{
            $status = 'Lunas';
            }
                $response["tagihan"][]=array(
                    "tg_id" => $dt->tg_id,
                    "op_nama" => $dt->op_nama,
                    "tanggal" => date('d M Y', strtotime($dt->tanggal)),
                    "nama_wajib_pajak" => $dt->nama,
                    "tarif" => $dt->tarif,
                    "denda" => $dt->denda,
                    "total_tagihan" => $dt->pajak_air_tanah,
                    "op_alamat" => $dt->op_alamat,
                    "pemakaian" => $dt->pemakaian,
                    "status" => $status,
                );
            } echo json_encode($response);
            } else {
                $response["error"] = TRUE;
                $response["error_msg"] = "Data Kosong";
 		        $response["tagihan"][]=array(
                    "tg_id" => "Data Kosong",
                    "op_nama" =>"Data Kosong",
                    "nama_wajib_pajak" => "Data Kosong",
                    "total" => "Data Kosong",);
                echo json_encode($response);
            }
    }

  

function uploadImage(Request $request) {

    $image = $request->image;
    $name = $request->name;
    $op_id = $request->op_id;
    $path = $request->path;
    $longitude = $request->longitude;
    $latitude = $request->latitude;
    

    $response = array();
    $decodedImage1 = base64_decode("$image");
    $namerandom = $name."-".$random = Str::random(10)."-".date('MY', strtotime(now()));

    $random = Str::random(40);
    if (!file_exists($path)){
        mkdir($path,  0777, true);
    }else{
    }
    
    $data = DB::table('foto_penggunaan')->insert([
        'foto_gambar' => $namerandom.".JPG",
        'path' => $path,
        'op_id' => $op_id,
        'foto_bulan'  =>  date('m', strtotime(now())),
        'foto_tahun'  =>  date('Y', strtotime(now())),
        'dibuat_pada' => now(),
        'status_input' => 0,
        'longitude' => $longitude,
        'latitude' => $latitude,

    ]);

    if ($data !== false) {
        $return = file_put_contents($path. $namerandom.".JPG",  $decodedImage1);
        $response['success'] = 1;
        $response['message'] = "Uploaded Successfully";
        echo json_encode($response);
    } else {
        $response['success'] = 0;
        $response['message'] = "Uploaded Failed";
        echo json_encode($response);
    }
    
  
}

function statuslaporan($id){
    $data = DB::table('foto_penggunaan')->orderBy('foto_penggunaan.foto_id','asc')
    ->join('tb_objek_pajak', 'foto_penggunaan.op_id','tb_objek_pajak.op_id')
    ->join('tb_wajib_pajak', 'tb_wajib_pajak.wp_id','tb_objek_pajak.wp_id')
    ->where('tb_wajib_pajak.wp_id','like',"%".$id."%")->get();
    
    if ($data !== null){
        $response["error"] = FALSE;
        $response["message"] = "Data Ditampilkan";
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

        $nama= substr($dt->foto_gambar,0,-23);

            $response["statuslaporan"][]=array(
                "nama" => '#'.$nama,
                "foto_id" => $dt->foto_id,
                "op_nama" => $dt->op_nama,
                "foto_bulan" => $dt->foto_bulan,
                "foto_tahun" => $dt->foto_tahun,
                "status" => $status,
            );
        } echo json_encode($response);
        } else {
            $response["error"] = TRUE;
            $response["error_msg"] = "Data Kosong";
            echo json_encode($response);
        }
}


}