<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Jenis;

class JenisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenis = DB::table ('tb_jenis')->get();
        $data=array(
            'jenis' => $jenis
        );
        return view ('jenis.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jenis.add');
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
            'jn_nama' => 'required',
        ]);

        $jenis = new jenis;
        $jenis->jn_nama = $request->jn_nama;
        $jenis->dibuat_pada = now();
        $jenis->diupdate_pada =now();
        $jenis->save();

        session()->flash('success','Sukses tambah jenis!');
        return redirect()->route('jenis.index');
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
    public function edit (jenis $jeni)
    {
        return view('jenis.edit', compact('jeni'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, jenis $jeni)
    {
        $request->validate([
            'jn_nama' => 'required'
        ]);

        
        $jeni->jn_nama = $request->jn_nama;
        $jeni->diupdate_pada = now();
        $jeni->save();

        session()->flash('success','Sukses ubah data jenis!');
        return redirect()->route('jenis.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
