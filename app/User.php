<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\UsersSearch;
use App\Users;
use App\Traits\UserTrait;

class User extends Model
{
    use UserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'balance', 'is_active', 'activate_code', 'ip'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function balance() {
        return $this->hasMany('App\UsersPayments', 'user_id', 'id');
    }

    public function comments() {
        return $this->hasMany('App\UsersComments', 'user_id', 'id');
    }
}
