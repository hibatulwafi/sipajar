<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Tmuser extends Authenticatable
{
    protected $table ='tm_user_login'; 
    protected $primaryKey = 'id';
    
    protected $fillable = [
       'id', 'user_first_name', 'user_email', 'user_password','user_last_name','user_role_id',
       'user_avatar','user_status','user_kode','created_at','updated_at' , 'remember_token'
    ];

    protected $hidden = [
        'remember_token',
    ];

    public function getAuthPassword()
    {
     return $this->user_password;
    }

   public function setPasswordAttribute($val)
    {
        return $this->attributes['user_password'] = bcrypt($val);
    }
 
}
