<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penggunaan extends Model
{
    protected $table ='tb_penggunaan'; 
    public $timestamps = false;
    protected $primaryKey = 'pg_id';
}
