<?php

namespace App\Http\Controllers\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use App\Http\Requests\PaymentRequest;
use Ixudra\Curl\Facades\Curl;
use App\User;
use App\Cars;
use App\UsersPayments;
use App\UsersSearch;

class StatsController extends \App\Http\Controllers\Controller
{
    public function apiStats() {
	if (!Cache::has("stats")) {
	    $stats['users']['active'] 			= User::whereIsActive(1)->count();
	    $stats['users']['inactive'] 		= User::whereIsActive(0)->count();
	    $stats['users']['all']			= $stats['users']['active'] + $stats['users']['inactive'];

	    $stats['users']['month']['active'] 		= User::whereIsActive(1)->whereBetween("created_at", [Carbon::now()->subMonth(), Carbon::now()])->count();
	    $stats['users']['month']['inactive'] 	= User::whereIsActive(0)->whereBetween("created_at", [Carbon::now()->subMonth(), Carbon::now()])->count();
	    $stats['users']['month']['all']		= $stats['users']['month']['active'] + $stats['users']['month']['inactive'];

	    $stats['cars']['all']			= Cars::count();
	    $stats['cars']['month']['all']		= Cars::whereBetween("created_at", [Carbon::now()->subMonth(), Carbon::now()])->count();

	    $stats['paid']['all']			= UsersPayments::wherePaid(1)->count();
	    $stats['paid']['balance']			= UsersPayments::wherePaid(1)->sum("balance");
	    $stats['paid']['month']['all']		= UsersPayments::wherePaid(1)->whereBetween("created_at", [Carbon::now()->subMonth(), Carbon::now()])->count();
	    $stats['paid']['month']['balance']		= UsersPayments::wherePaid(1)->whereBetween("created_at", [Carbon::now()->subMonth(), Carbon::now()])->sum("balance");

	    $stats['search']['all']			= UsersSearch::count();
	    $stats['search']['found']			= UsersSearch::whereFound(1)->count();
	    $stats['search']['nofound']			= UsersSearch::whereFound(0)->count();
	    $stats['search']['paid']			= UsersSearch::wherePaid(1)->count();
	    $stats['search']['sms']			= UsersSearch::wherePaid(1)->whereType("sms")->count();
	    $stats['search']['call']			= UsersSearch::wherePaid(1)->whereType("call")->count();

	    $stats['search']['month']['all']		= UsersSearch::whereBetween("created_at", [Carbon::now()->subMonth(), Carbon::now()])->count();
	    $stats['search']['month']['found']		= UsersSearch::whereBetween("created_at", [Carbon::now()->subMonth(), Carbon::now()])->whereFound(1)->count();
	    $stats['search']['month']['nofound']	= UsersSearch::whereBetween("created_at", [Carbon::now()->subMonth(), Carbon::now()])->whereFound(0)->count();
	    $stats['search']['month']['paid']		= UsersSearch::whereBetween("created_at", [Carbon::now()->subMonth(), Carbon::now()])->wherePaid(1)->count();
	    $stats['search']['month']['sms']		= UsersSearch::whereBetween("created_at", [Carbon::now()->subMonth(), Carbon::now()])->wherePaid(1)->whereType("sms")->count();
	    $stats['search']['month']['call']		= UsersSearch::whereBetween("created_at", [Carbon::now()->subMonth(), Carbon::now()])->wherePaid(1)->whereType("call")->count();

	    Cache::put('stats', $stats, Carbon::now()->addHour());
	}
	else 
	    $stats = Cache::get("stats");

	return response()->json($stats);
    }


}
