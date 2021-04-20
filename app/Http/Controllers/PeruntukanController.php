<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PeruntukanController extends Controller
{
    public function index(){
        $peruntukan = DB::table ('tb_kelompok')->get();
        $peruntukan=array(
            'peruntukan' => $peruntukan
        );
        return view ('peruntukan.index',$peruntukan);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sda.add');
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

        $kota = new kota;
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
