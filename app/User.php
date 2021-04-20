<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table ='tm_user_login'; 
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_first_name', 'user_email', 'user_password','user_last_name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
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
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    /**protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    

    public function level() {
        return $this->belongsTo('App\Level');
    }
     */
}
