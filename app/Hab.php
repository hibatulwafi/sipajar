<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hab extends Model
{
    protected $table ='tm_harga_baku'; 
    public $timestamps = false;
    protected $primaryKey = 'harga_id';
}
