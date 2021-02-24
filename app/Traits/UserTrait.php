<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


trait UserTrait
{
    public static function bootUserTrait()
    {
        static::creating(function (Model $model) {
	    DB::enableQueryLog();
	    $user = \App\UsersSearch::rightJoin("cars", "cars.regnumber", "=", "users_search.regnumber")->rightJoin("users", "users.id", "=", "users_search.user_id")->rightJoin("system_users", "system_users.phone", "=", "users.phone")->where("cars.phone", "=", $model->phone)->orderBy("users_search.created_at", "desc")->select(["system_users.id"])->first();
	    Log::info(json_encode(DB::getQueryLog()));

    	    if ($user !== null) {
    	        $model->system_user_id = $user->id;
    	    }
	});
    }
}