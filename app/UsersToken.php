<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersToken extends Model
{
    protected $table = 'users_token';
    public $timestamps = true;
    protected $fillable = ['user_id', 'token', 'expired'];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
