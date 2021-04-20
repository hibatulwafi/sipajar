<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WajibPajak extends Model
{
    protected $table ='tb_wajib_pajak'; 
    public $timestamps = false;
    protected $primaryKey = 'wp_id';
}
