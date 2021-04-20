<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Kecamatan;
use App\Kota;

use Str;


class KecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kecamatans = DB::table ('tb_kecamatan')
        ->join('tb_kota', 'tb_kecamatan.kota_id','tb_kota.kota_id')
        ->get();
        $data=array(
            'kecamatans' => $kecamatans
        );
        return view ('kecamatan.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kota = DB::table ('tb_kota')->get();
        $data=array(
            'combo' => $kota
        );
        return view('kecamatan.add',$data);
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
            'kecamatan_nama' => 'required',
            'kota_id' => 'required'
        ]);

        $q=DB::table('tb_kecamatan')->select(DB::raw('MAX(kecamatan_id) as kd_max'));
        if($q->count()>0) {foreach($q->get() as $k){$id = $k->kd_max+1;}
        }else{$id = "1";}

        $kecamatan = new kecamatan;
        $kecamatan->kecamatan_id = $id;
        $kecamatan->kecamatan_nama = $request->kecamatan_nama;
        $kecamatan->kota_id = $request->kota_id;
        $kecamatan->save();

        session()->flash('success','Sukses tambah kecamatan!');
        return redirect()->route('kecamatan.index');
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
    public function edit(kecamatan $kecamatan)

    {   $kecamatan = kecamatan::findOrFail($kecamatan->kecamatan_id);
        $kota = DB::table ('tb_kota')->get();

        return view('kecamatan.edit',compact('kecamatan', 'kota'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, kecamatan $kecamatan)
    {
        $request->validate([
            'kecamatan_nama' => 'required',
            'kota_id' => 'required'
        ]);

        $kecamatan->kecamatan_nama = $request->kecamatan_nama;
        $kecamatan->kota_id = $request->kota_id;
        $kecamatan->save();

        session()->flash('success','Sukses ubah data kecamatan!');
        return redirect()->route('kecamatan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(kecamatan $kecamatan)
    {
        $kecamatan->delete();

        session()->flash('success','Sukses hapus kecamatan!');
        return redirect()->back();
    }
}
