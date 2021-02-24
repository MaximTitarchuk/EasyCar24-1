<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersComments extends Model
{
    protected $table = 'users_comments';
    public $timestamps = true;
    protected $fillable = ['system_user_id', 'user_id', 'comment'];

    public function user() {
        return $this->belongsTo('App\SystemUser', 'system_user_id');
    }
}
