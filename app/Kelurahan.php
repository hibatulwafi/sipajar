<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table ='tb_kelurahan'; 
    public $timestamps = false;
    protected $primaryKey = 'kelurahan_id';

    public function kecamatan() {
        return $this->belongsTo('App\Kecamatan','kecamatan_id', 'kecamatan_id');
    }

}
