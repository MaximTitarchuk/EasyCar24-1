<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersPush extends Model
{
    protected $table = 'users_push';
    public $timestamps = true;
    protected $fillable = ['user_id', 'system', 'regid'];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
