<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Kecamatan;
use App\Kelurahan;

class KelurahanController extends Controller
{/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelurahans = DB::table ('tb_kelurahan')
        ->join('tb_kecamatan', 'tb_kelurahan.kecamatan_id','tb_kecamatan.kecamatan_id')
        ->get();
        $data=array(
            'kelurahans' => $kelurahans
        );
        return view ('kelurahan.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kecamatan = DB::table ('tb_kecamatan')->get();
        $data=array(
            'combo' => $kecamatan
        );
        return view('kelurahan.add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kelurahan_nama' => 'required',
            'kecamatan_id' => 'required'
        ]);

        $q=DB::table('tb_kelurahan')->select(DB::raw('MAX(kelurahan_id) as kd_max'));
        if($q->count()>0) {foreach($q->get() as $k){$id = $k->kd_max+1;}
        }else{$id = "1";}

        $kelurahan = new kelurahan;
        $kelurahan->kelurahan_id = $id;
        $kelurahan->kelurahan_nama = $request->kelurahan_nama;
        $kelurahan->kecamatan_id = $request->kecamatan_id;
        $kelurahan->save();

        session()->flash('success','Sukses tambah kelurahan!');
        return redirect()->route('kelurahan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(kelurahan $kelurahan)
    {   
        $cek = Kecamatan::where('kecamatan_id', 'LIKE', $kelurahan->kecamatan_id )->get();
        $kecamatan = Kecamatan::where('kecamatan_id', 'NOT LIKE', $kelurahan->kecamatan_id )->get();
        return view('kelurahan.edit', compact('kelurahan','kecamatan','cek'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, kelurahan $kelurahan)
    {
        $request->validate([
            'kelurahan_nama' => 'required',
            'kecamatan_id' => 'required'
        ]);

        $kelurahan->kelurahan_nama = $request->kelurahan_nama;
        $kelurahan->kecamatan_id = $request->kecamatan_id;
        $kelurahan->save();

        session()->flash('success','Sukses ubah data kelurahan!');
        return redirect()->route('kelurahan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(kelurahan $kelurahan)
    {
        $kelurahan->delete();

        session()->flash('success','Sukses hapus kelurahan!');
        return redirect()->back();
    }
}
