<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Facades\Datatables;

use Illuminate\Http\Request;

use App\User;
use App\UserPayments;

use Carbon\Carbon;

class PromoController extends Controller
{

    /**
     * Display a listing users
     *
     * @return Response
     */
    public function index()
    {
        return View('backend.promo.promo');
    }

    public function data()
    {
        return Datatables
		    ::collection(
//			User::leftJoin("users_payments", "users_payments.user_id", "=", "users.id")->select("users.id", "users.phone", DB::raw("sum(users_payments.balance) as balance"))->wherePaid(1)->whereSystemUserId(Auth::user()->id)->orderBy("users.phone", "asc")->groupBy("user_id")->get()
			User::select("users.id", "users.phone")->whereSystemUserId(Auth::user()->id)->orderBy("users.phone", "asc")->get()
		    )
		    ->addColumn('balance', function($model){
			return $model->balance()->wherePaid(1)->sum("balance");
		    })
		    ->addColumn('actions', function($model){
			return '<button type="button" class="btn btn-primary btn-sm edit" data-id="'.$model->id.'"><i class="fa fa-pencil" aria-hidden="true"></i></button>&nbsp;'.
				'<button type="button" class="btn btn-success btn-sm balance" data-id="'.$model->id.'"><i class="fa fa-money" aria-hidden="true"></i></button>';
		    })
		    ->make(true);
    }


}

