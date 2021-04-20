<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Kota;
use Str;

class KotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $kotas = DB::table ('tb_kota')->get();
        $data=array(
            'kotas' => $kotas
        );
        return view ('kota.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kota.add');
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
            'kota_nama' => 'required',
        ]);

        $q=DB::table('tb_kota')->select(DB::raw('MAX(kota_id) as kd_max'));
        if($q->count()>0) {foreach($q->get() as $k){$id = $k->kd_max+1;}
        }else{$id = "1";}

        $kota = new kota;
        $kota->kota_id = $id;
        $kota->kota_nama = $request->kota_nama;
        $kota->save();

        session()->flash('success','Sukses tambah kota!');
        return redirect()->route('kota.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function show(kota $kota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function edit(kota $kotum)
    {
        return view('kota.edit', compact('kotum'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, kota $kotum)
    {
        $request->validate([
            'kota_nama' => 'required'
        ]);

        
        $kotum->kota_nama = $request->kota_nama;
        $kotum->save();

        session()->flash('success','Sukses ubah data kota!');
        return redirect()->route('kota.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function destroy(kota $kotum)
    {
        $kotum->delete();

        session()->flash('success','Sukses hapus kota!');
        return redirect()->back();
    }
}
