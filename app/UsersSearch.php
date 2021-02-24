<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersSearch extends Model
{
    protected $table = 'users_search';
    public $timestamps = true;
    protected $fillable = ['user_id', 'regnumber', 'cost', 'paid', 'found', 'type'];

    public function user() {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function car() {
        return $this->hasOne('App\Cars', 'regnumber', 'regnumber')->first();
    }
}
