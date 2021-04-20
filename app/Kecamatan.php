<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table ='tb_kecamatan'; 
    public $timestamps = false;
    protected $primaryKey = 'kecamatan_id';

    public function kota() {
        return $this->belongsTo('App\Kota','kota_id', 'kota_id');
    }

}
