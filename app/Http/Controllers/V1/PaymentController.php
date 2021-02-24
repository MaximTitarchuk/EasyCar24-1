<?php

namespace App\Http\Controllers\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use App\Http\Requests\PaymentRequest;
use Ixudra\Curl\Facades\Curl;
use App\User;
use App\UsersPayments;

class PaymentController extends \App\Http\Controllers\Controller
{
    private $secret1 = "5l6av2t9";
    private $secret2 = "waa1c3di";
    private $shop_id = 28831;

    public function addPayment(PaymentRequest $request) {
		$user = User::wherePhone($request->phone)->first();

		$payment = UsersPayments::create([
			"user_id"		=> $user->id,
			"balance"		=> $request->sum,
			"paid"		=> 0,
			"description"	=> "Пополнение баланса через форму оплаты на сайте",
		]);

		$sign = md5("{$this->shop_id}:{$request->sum}:{$this->secret1}:{$payment->id}");
		$url = "http://www.free-kassa.ru/merchant/cash.php?m=28831&oa={$request->sum}&o={$payment->id}&s={$sign}";
		return response()->json(["redirect" => $url]);
    }

    /*
     * @param phone телефон пользователя, 10 цифр
     * @param code пинкод, 4 цифры
     *
     * @result json
     */
    public function apiPayment() {
		$data = json_encode(Input::all());

		try {
			if ((int) Input::get("MERCHANT_ID") !== (int) $this->shop_id)
			return response("Некорректный MERCHANT_ID");

			$sign = md5(Input::get("MERCHANT_ID").':'.Input::get("AMOUNT").":{$this->secret2}:".Input::get("MERCHANT_ORDER_ID"));

			if (strtolower($sign) != strtolower(Input::get("SIGN")))
			return response("Некорректная подпись запроса");

			$payment = UsersPayments::whereId(Input::get("MERCHANT_ORDER_ID"))->whereBalance(Input::get("AMOUNT"))->firstOrFail();

			$special = \App\Specials
				::where("date_from", "<=", Carbon::now())
				->where("date_to", ">=", Carbon::now())
				->where("sum_from", "<=", (int) Input::get("AMOUNT"))
				->where("sum_to", ">=", (int) Input::get("AMOUNT"))
				->first();

			$payment->update([
			    "paid"		=> 1,
			    "data"		=> $data
			]);

			$user = $payment->user()->first();
			$user->update([
				"balance"	=> $user->balance + (int) Input::get("AMOUNT") + ($special !== null? ((int) Input::get("AMOUNT")) * $special->percent / 100: 0)
			]);

		} catch (ModelNotFoundException $e) {
			return response("Платеж не найден. Обратитесь в поддержку info@ksri.info");
		}


		return "YES";


    }

}
