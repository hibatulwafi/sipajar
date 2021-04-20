<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FotoPenggunaan extends Model
{
    protected $table ='foto_penggunaan'; 
    public $timestamps = false;
    protected $primaryKey = 'foto_id';
}
