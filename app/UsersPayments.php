<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersPayments extends Model
{
    protected $table = 'users_payments';
    public $timestamps = true;
    protected $fillable = ['user_id', 'balance', 'paid', 'description', 'data'];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

}
