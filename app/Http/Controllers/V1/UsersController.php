<?php

namespace App\Http\Controllers\V1;

use App\UsersPayments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use Ixudra\Curl\Facades\Curl;
use App\Http\Controllers\SmsController;

use App\User;
use App\Cars;
use App\UsersToken;
use App\UsersPush;

class UsersController extends \App\Http\Controllers\Controller
{
    /*
        Api v1
    */

    private $expired = 60 * 24; // 1 сутки

    /*
     * @param phone телефон пользователя, 10 цифр
     * @param code пинкод, 4 цифры
     *
     * @result json
     */
    public function apiUserRegistation() {
        $validator = Validator::make(
            ['phone' => Input::get("phone"), "code" => Input::get("code")],
            ['phone' => "required|regex:/^[0-9]{10}$/i", "code" => "required|regex:/^[0-9]{4}$/i"]
        );

        if ($validator->fails()) {
            $messages = $validator->messages();

            if ($messages->has('phone'))
                return response()->json(["code" => 10, "error" => "Не корректно введен номер телефона"], 422);
            if ($messages->has('code'))
                return response()->json(["code" => 11, "error" => "Не корректно введен проверочный код"], 422);
        }

        $validator = Validator::make(
            ['phone' => Input::get("phone")],
            ['phone' => "unique:users,phone"]
        );

        if ($validator->fails()) {
            return response()->json(["code" => 12, "error" => "Номер телефона уже зарегистрирован в системе"], 422);
        }

        if (!$this->checkSign(Input::get("code")))
            return response()->json(["code" => 5, "error" => "Параметры переданы некорректно"], 422);

        $user = new User;
        $user->phone = Input::get("phone");
        $user->code = Input::get("code");
        $user->balance = config("app.reg_balance");
        $user->activate_code = mt_rand(1000, 9999);
        $user->save();

#	$response = Curl::to(asset('/api/users/auth'))
#	    ->withData(["phone" => Input::get("phone"), "sign" => sha1(Input::get("phone").":".Input::get("code"))])
#    	    ->post();
#        return response()->json([json_decode($response)], 200);

        $sms = new SmsController();
        $sms->send(["text" => "Код активации: " . $user->activate_code], ["7" . $user->phone]);

        return response()->json(["code" => 0], 200);
    }

    /*
     * @param phone телефон пользователя, 10 цифр
     * @param sign подпись запроса
     *
     * @result json
     */
    public function apiUserAuth() {
        $validator = Validator::make(
            ['phone' => Input::get("phone")],
            ['phone' => "required|regex:/^[0-9]{10}$/i"]
        );

        if ($validator->fails())
            return response()->json(["code" => 10, "error" => "Не корректно введен номер телефона"], 422);

        $validator = Validator::make(
            ['phone' => Input::get("phone")],
            ['phone' => "exists:users,phone"]
        );

        if ($validator->fails())
            return response()->json(["code" => 20, "error" => "Номер телефона не зарегистрирован в системе"], 422);

        $user = User::wherePhone(Input::get("phone"))->first();

        if (!$user->is_active)
            return response()->json(["code" => 21, "error" => "Пользователь не активирован"], 422);

        if (!$this->checkSign($user->code))
            return response()->json(["code" => 5, "error" => "Параметры переданы некорректно"], 422);

        $expired = Carbon::now()->addMinute($this->expired);
        $token = UsersToken::create([
            "user_id" => $user->id,
            "token" => str_random(50),
            "expired" => $expired
        ]);

        $ipAddress = $_SERVER['REMOTE_ADDR'];
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER))
            $ipAddress = array_pop(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']));

        $geo = new \App\Http\Controllers\GeoIPController(storage_path() . "/SxGeoCity.dat");
        $region = $geo->getCityFull($ipAddress);
        if (isset($region['region']['iso']))
            $region = $region['region']['iso'];
        else
            $region = null;

        $user->ip = ip2long($ipAddress);
        $user->region = $region;
        $user->save();

        return response()->json([
            "code" => 0,
            "name" => $user->name,
            "email" => $user->email,
            "phone" => $user->phone,
            "balance" => $user->balance,
            "token" => $token->token,
            "expired" => $expired->timestamp
        ], 200);
    }

    /*
     * @param phone телефон пользователя, 10 цифр
     * @param activate_code телефон пользователя, 10 цифр
     * @param sign подпись запроса
     *
     * @result json
     */
    public function apiUserActivate() {
        $validator = Validator::make(
            ['phone' => Input::get("phone"), "activate_code" => Input::get("activate_code")],
            ['phone' => "required|regex:/^[0-9]{10}$/i", "activate_code" => "required|regex:/^[0-9]{4}$/i"]
        );

        if ($validator->fails()) {
            $messages = $validator->messages();

            if ($messages->has('phone'))
                return response()->json(["code" => 10, "error" => "Некорректно введен номер телефона"], 422);
            if ($messages->has('activate_code'))
                return response()->json(["code" => 22, "error" => "Некорректно введен проверочный код"], 422);
        }


        $validator = Validator::make(
            ['phone' => Input::get("phone")],
            ['phone' => "exists:users,phone"]
        );

        if ($validator->fails())
            return response()->json(["code" => 20, "error" => "Номер телефона не зарегистрирован в системе"], 422);

        $user = User::wherePhone(Input::get("phone"))->first();

        if ($user->is_active)
            return response()->json(["code" => 23, "error" => "Пользователь уже активирован"], 422);
        elseif ($user->activate_code != Input::get("activate_code"))
            return response()->json(["code" => 22, "error" => "Некорректно введен проверочный код"], 422);

        if (!$this->checkSign($user->code))
            return response()->json(["code" => 5, "error" => "Параметры переданы некорректно"], 422);


        $user->is_active = true;
        $user->activate_code = null;
        $user->save();

        $referer = Cars
            ::rightJoin("users_search", "users_search.regnumber", "=", "cars.regnumber")
            ->where("cars.phone", $user->phone)
            ->whereBetween("users_search.created_at", [
                Carbon::now()->subDay(),
                Carbon::now()
            ])
            ->first();

        if ($referer !== null) {
	    $recomend = config("app.recomend");

            $ref = User::find($referer->user_id);
            $ref->balance += $recomend;
            $ref->save();

            $phone = "(".substr($referer->phone, 0, 3).") ".substr($referer->phone, 3, 3)."-XXXX";

            UsersPayments::create([
                "user_id"       => $referer->user_id,
                "balance"       => $recomend,
                "paid"          => true,
                "description"   => "Рекомендация приложения для пользователя {$phone} {$referer->regnumber}. Начислено {$recomend}руб."
            ]);

	    $sms = new SmsController();
            $sms->send(["text" => "Новая регистрация от {$phone} {$referer->regnumber}. Вам +{$recomend} руб"], ["7" . $ref->phone]);
        }


        $response = Curl::to(asset('/api/v1/users/auth'))
            ->withData(["phone" => Input::get("phone"), "sign" => sha1(Input::get("phone") . ":" . $user->code)])
            ->post();

        return response()->json([json_decode($response)], 200);
    }




    /*
     * @param phone телефон пользователя, 10 цифр
     *
     * @result json
     */
    public function apiUserPasswordRecovery() {
        $validator = Validator::make(
            ['phone' => Input::get("phone")],
            ['phone' => "required|regex:/^[0-9]{10}$/i"]
        );

        if ($validator->fails())
            return response()->json(["code" => 10, "error" => "Не корректно введен номер телефона"], 422);

        $validator = Validator::make(
            ['phone' => Input::get("phone")],
            ['phone' => "exists:users,phone"]
        );

        if ($validator->fails())
            return response()->json(["code" => 20, "error" => "Номер телефона не зарегистрирован в системе"], 422);

        $user = User::wherePhone(Input::get("phone"))->first();

        $sms = new SmsController();

        if (Cache::has("recovery_" . $user->phone)) {
            return response()->json(["code" => 40, "error" => "Вы можете запросить свой пинкод только через 5 минут"], 422);
        } else {
            $code = mt_rand(10000, 99999);
            Cache::put('recovery_' . $user->phone, $user->code, 5);
        }

        $sms->send(["text" => "Пинкод: " . $user->code], ["7" . $user->phone]);

        return response()->json([
            "code" => 0,
        ], 200);
    }

    /*
     * @param phone телефон пользователя, 10 цифр
     *
     * @result json
     */
    public function apiUserBalance() {
        $validator = Validator::make(
            ['phone' => Input::get("phone")],
            ['phone' => "required|regex:/^[0-9]{10}$/i"]
        );

        if ($validator->fails())
            return response()->json(["code" => 10, "error" => "Не корректно введен номер телефона"], 422);

        $validator = Validator::make(
            ['phone' => Input::get("phone")],
            ['phone' => "exists:users,phone"]
        );

        if ($validator->fails())
            return response()->json(["code" => 20, "error" => "Номер телефона не зарегистрирован в системе"], 422);

        $user = User::wherePhone(Input::get("phone"))->first();

        if (!$this->checkSign($user->code))
            return response()->json(["code" => 5, "error" => "Параметры переданы некорректно"], 422);

        return response()->json([
            "code" => 0,
            "balance" => $user->balance
        ], 200);
    }

    /*
     * @param phone телефон пользователя, 10 цифр
     *
     * @result json
     */
    public function apiUserSendActivateCode() {
        $validator = Validator::make(
            ['phone' => Input::get("phone")],
            ['phone' => "required|regex:/^[0-9]{10}$/i"]
        );

        if ($validator->fails()) {
            $messages = $validator->messages();

            if ($messages->has('phone'))
                return response()->json(["code" => 10, "error" => "Не корректно введен номер телефона"], 422);
        }

        $validator = Validator::make(
            ['phone' => Input::get("phone")],
            ['phone' => "exists:users,phone"]
        );

        if ($validator->fails()) {
            return response()->json(["code" => 20, "error" => "Номер телефона не зарегистрирован в системе"], 422);
        }

        $user = User::wherePhone(Input::get("phone"))->first();
 
        if (!$this->checkSign($user->code))
            return response()->json(["code" => 5, "error" => "Параметры переданы некорректно"], 422);

	if ($user->activate_code == "") {
            $user->activate_code = mt_rand(1000, 9999);
	    $user->save();
	}

        $sms = new SmsController();
        $sms->send(["text" => "Код активации: " . $user->activate_code], ["7" . $user->phone]);

        return response()->json(["code" => 0], 200);
    }

    public function apiUserRegistrationApplication() {
        $validator = Validator::make(
            [
                "token" => Input::get("token"),
                "system" => Input::get("system"),
                "regid" => Input::get("regid")
            ],
            [
                "token" => "required|regex:/^[A-Za-z0-9]{50}$/i|exists:users_token,token",
                "system" => "required|in:ios,android",
                "regid" => "required|unique:users_push,regid",
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->messages();

            if ($messages->has('token'))
                return response()->json(["code" => 3, "error" => "Токен введен некорректно"], 422);
            if ($messages->has('system'))
                return response()->json(["code" => 60, "error" => "Параметр системы введен некорректно"], 422);
            if ($messages->has('regid'))
                return response()->json(["code" => 61, "error" => "ID приложения введен некорректно"], 422);
        }

        $token = UsersToken::whereToken(Input::get("token"))->first();
        if (Carbon::parse($token->expired) < Carbon::now())
            return response()->json(["code" => 4, "error" => "Токен просрочен"], 422);

        if (!$this->checkSign($token->user()->first()->code))
            return response()->json(["code" => 5, "error" => "Параметры переданы некорректно"], 422);

        UsersPush::create([
            "user_id" => $token->user_id,
            "system" => Input::get("system"),
            "regid" => Input::get("regid")
        ]);

        return response()->json(["code" => 0], 200);
    }
}
