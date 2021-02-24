<?php

namespace App\Http\Controllers\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\AsteriskController;

use App\Cars;
use App\UsersSearch;
use App\UsersToken;
use App\Jobs\Call;

use App\Http\Controllers\SmsController;



class CallController extends \App\Http\Controllers\Controller
{
    public function apiConnectionPhones() {
        $validator = Validator::make(
            [
                'search_id' => Input::get("search_id"),
                "token"     => Input::get("token")
            ],
            [
                'search_id' => "required|integer|exists:users_search,id,paid,0,found,1",
                "token"     => "required|regex:/^[A-Za-z0-9]{50}$/i|exists:users_token,token",
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->messages();

            if ($messages->has('search_id'))
                return response()->json(["code" => 50, "error" => "Запрос не существует"], 422);
            if ($messages->has('token'))
                return response()->json(["code" => 3, "error" => "Токен введен некорректно"], 422);
        }

        $token = UsersToken::whereToken(Input::get("token"))->first();
        if (Carbon::parse($token->expired) < Carbon::now())
            return response()->json(["code" => 4, "error" => "Токен просрочен"], 422);


        $search = UsersSearch::find(Input::get("search_id"));
        if ($search->user_id != $token->user_id)
            return response()->json(["code" => 50, "error" => "Запрос не существует"], 422);

        $user = $token->user()->lockForUpdate()->first();
        if ($user->balance < config("app.cost_call"))
            return response()->json(["code" => 6, "error" => "Нет средств на счету"], 422);

        if ($user->balance < config("app.cost_call"))
            return response()->json(["code" => 6, "error" => "Нет средств на счету"], 422);

        if (!$this->checkSign($user->code))
            return response()->json(["code" => 5, "error" => "Параметры переданы некорректно"], 422);


        $car = $search->car();


	Log::info("1");
	Queue::later(10, 'App\Jobs\Call@call', [$search->id, "7".$user->phone, "7".$car->phone]);
//	Queue::later(10, new Call($search->id, "7".$user->phone, "7".$car->phone));

//	$call = new AsteriskController();
//	$result = $call->call($search->id, "7".$user->phone, "7".$car->phone);

#	if ($result === false)
#	    return response()->json(["code" => 70, "error" => "Ошибка при звонке абоненту"], 422);
	Log::info("2");

        return response()->json(["code" => 0], 200);
    }

    public function apiUpdateStatus($callId) {
        $validator = Validator::make(
            [
                'callid'	=> $callId
            ],
            [
                'callid' 	=> "required|integer|exists:users_search,id,paid,0,found,1",
            ]
        );

        if ($validator->fails())
            return response()->json(["code" => 50, "error" => "Запрос не существует"], 422);

        $search = UsersSearch::find($callId);
        $user = $search->user()->first();
        $car = $search->car();

        $user->update(["balance" => $user->balance - config("app.cost_call")]);
	$search->update(["paid" => true, "type" => "call", "cost" => config("app.cost_call")]);

        Queue::later(1, 'App\Jobs\SendPush@payment', [
            "id"        => $search->id
        ]);


	return response()->json(["code" => 0], 200);
    }
}
