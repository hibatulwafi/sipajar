<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObjekPajak extends Model
{
    protected $table ='tb_objek_pajak'; 
    public $timestamps = false;
    protected $primaryKey = 'op_id';
    public function WajibPajak() {
        return $this->belongsTo('App\WajibPajak', 'wp_id');
    }
    public function Jenis() {
        return $this->belongsTo('App\Jenis', 'jn_id');
    }
}