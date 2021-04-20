<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
    protected $table ='tb_pesan'; 
    public $timestamps = false;
    protected $primaryKey = 'pesan_id';
}
