<?php

namespace App\Http\Controllers\V1;

use App\Cars;

use App\UsersSearch;
use App\UsersToken;
use App\Http\Controllers\SmsController;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CarsController extends \App\Http\Controllers\Controller
{
    /*
	Api v1
    */

    public function apiSearchRegNumber()
    {
        $regnumber = trim(mb_strtoupper(Input::get("regnumber")));

        $validator = Validator::make(
            ['regnumber' => $regnumber, "token" => Input::get("token")],
            [
                'regnumber' => "required|regex:/^[АВЕКМНОРСТУХ]{2}[0-9]{3}[АВЕКМНОРСТУХ]{4}[0-9]{2,3}$/i",
                "token"     => "required|regex:/^[A-Za-z0-9]{50}$/i|exists:users_token,token",
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->messages();

            if ($messages->has('regnumber'))
                return response()->json(["code" => 1, "error" => "Передан некорректный регистрационный знак автомобиля"], 422);
            if ($messages->has('token'))
                return response()->json(["code" => 3, "error" => "Токен введен некорректно"], 422);
        }

        $token = UsersToken::whereToken(Input::get("token"))->first();
        if (Carbon::parse($token->expired) < Carbon::now())
            return response()->json(["code" => 4, "error" => "Токен просрочен"], 422);

        $user = $token->user()->first();

        try {
            $car = Cars::whereRegnumber($regnumber)->firstOrFail();

#            if ($user->balance < config("app.cost_request"))
#                return response()->json(["code" => 6, "error" => "Нет средств на счету"], 422);

            if (!$this->checkSign($user->code))
                return response()->json(["code" => 5, "error" => "Параметры переданы некорректно"], 422);

#            $user->update(["balance" => $user->balance - config("app.cost_request")]);
            $search = UsersSearch::create([
                "user_id"       => $user->id,
                "regnumber"     => Input::get("regnumber"),
                "cost"          => config("app.cost_sms"),
		"found"		=> true
            ]);
        } catch (ModelNotFoundException $e) {
            $search = UsersSearch::create([
                "user_id"       => $user->id,
                "regnumber"     => Input::get("regnumber"),
                "cost"          => config("app.cost_sms"),
		"paid"		=> false,
		"found"		=> false
            ]);
            return response()->json(["code" => 2, "error" => "Автомобиль с таким регистрационным знаком не найден"], 422);
        }

        $phone = "+7 (".mb_substr($car->phone, 0, 3).") ".mb_substr($car->phone, 3, 3)."-XX-XX";

Log::info($car->phone);

        return response()->json(["code" => 0, "phone" => $phone, "search_id" => $search->id], 200);
    }

    public function apiSendSms() {
        $validator = Validator::make(
            [
                'search_id' => Input::get("search_id"),
                "message"   => Input::get("message"),
                "token"     => Input::get("token")
            ],
            [
                'search_id' => "required|integer|exists:users_search,id,paid,0,found,1",
                'message'   => "required|string|max:70",
                "token"     => "required|regex:/^[A-Za-z0-9]{50}$/i|exists:users_token,token",
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->messages();

            if ($messages->has('search_id'))
                return response()->json(["code" => 50, "error" => "Запрос не существует"], 422);
            if ($messages->has('message'))
                return response()->json(["code" => 51, "error" => "Сообщение введено некорректно"], 422);
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
        if ($user->balance < config("app.cost_sms"))
            return response()->json(["code" => 6, "error" => "Нет средств на счету"], 422);

        if (!$this->checkSign($user->code))
            return response()->json(["code" => 5, "error" => "Параметры переданы некорректно"], 422);

        $car = $search->car();

        $user->update(["balance" => $user->balance - config("app.cost_sms")]);
        $search->update(["paid" => true]);

        $sms    = new SmsController();
        $ok = $sms->send(["text" => Input::get("message"), "sender" => "EasyCar24", "smsid" => "easycar24-".$search->id], ["7".$car->phone]);

	Queue::later(10, 'App\Jobs\SendPush@delivery_sms', [
	    "id" 	=> $search->id, 
	    "smsid" 	=> "easycar24-{$search->id}",
	]);

        return response()->json(["code" => 0], 200);
    }


    public function apiSearchRegNumber2()
    {
        $regnumber = trim(mb_strtoupper(Input::get("regnumber")));

        $validator = Validator::make(
            ['regnumber' => $regnumber],
            ['regnumber' => "required|regex:/^[АВЕКМНОРСТУХ]{2}[0-9]{3}[АВЕКМНОРСТУХ]{4}[0-9]{2,3}$/i"]
        );

        if ($validator->fails())
            return response()->json(["code" => 1, "error" => "Передан некорректный регистрационный знак автомобиля"], 422);

        try {
            $car = Cars::whereRegnumber($regnumber)->lockForUpdate()->firstOrFail();

        } catch (ModelNotFoundException $e) {
            return response()->json(["code" => 2, "error" => "Автомобиль с таким регистрационным знаком не найден"], 422);
        }

#        $phone = "+7 (".mb_substr($car->phone, 0, 3).") ".mb_substr($car->phone, 3, 3)."-XX-XX";
        $phone = "+7 (".mb_substr($car->phone, 0, 3).") ".mb_substr($car->phone, 3, 3)."-".mb_substr($car->phone, 6, 2)."-".mb_substr($car->phone, 8, 2);

        return response()->json(["code" => 0, "phone" => $phone], 200);
    }
}
