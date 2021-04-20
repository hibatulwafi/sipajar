<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Hab;
use Str;

class HABController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $hab = DB::table ('tm_harga_baku')->get();
        $data=array(
            'hab' => $hab
        );
        return view ('hab.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hab.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $q=DB::table('tm_harga_baku')->select(DB::raw('MAX(harga_id) as kd_max'));
        if($q->count()>0) {foreach($q->get() as $k){$id = $k->kd_max+1;}
        }else{$id = "1";}

        $hab = new hab;
        $hab->harga_id = $id;
        $hab->harga_jenis = $request->harga_jenis;
        $hab->harga_nominal = $request->harga_nominal;
        $hab->created_at = now();
        $hab->harga_status = 1;
        $hab->save();

        session()->flash('success','Sukses tambah kota!');
        return redirect()->route('hab.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function show(hab $hab)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function edit(hab $hab)
    {
        return view('hab.edit', compact('hab'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, hab $hab)
    {
        $hab = hab::findOrFail($hab->harga_id);
        $hab->harga_jenis = $request->harga_jenis;
        $hab->harga_nominal = $request->harga_nominal;
        $hab->harga_status = $request->status;
        $hab->updated_at = now();
        $hab->save();

        session()->flash('success','Sukses ubah data !');
        return redirect()->route('hab.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\kota  $kota
     * @return \Illuminate\Http\Response
     */
    public function destroy(hab $hab)
    {
        $hab->delete();

        session()->flash('success','Sukses hapus !');
        return redirect()->back();
    }
}
