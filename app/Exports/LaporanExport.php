<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class LaporanExport implements FromQuery
{
    public function __construct(string $bulan, string $tahun)
    {
        $this->name = $name;
        $this->bagian = $bagian;
    }
    
    public function  query()
    {
        $qry = DB::table ('tb_tagihan')->orderBy('tb_tagihan.created_at','DESC')
        ->join('tb_penggunaan','tb_tagihan.pg_id','tb_penggunaan.pg_id')
        ->join('tb_objek_pajak','tb_objek_pajak.op_id','tb_penggunaan.op_id')
        ->join('tb_wajib_pajak','tb_wajib_pajak.wp_id','tb_objek_pajak.wp_id')->select('tb_objek_pajak.op_nama','tb_objek_pajak.op_id','tb_wajib_pajak.nama',
                 'tb_penggunaan.bulan','tb_tagihan.pemakaian','tb_tagihan.biaya_bayar',
                 'tb_penggunaan.tahun','tb_tagihan.tarif','tb_tagihan.created_at')->get();

    }
}
