<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Input;

use App\Http\Controllers\SmsController;
use App\Http\Controllers\PushController;
use App\UsersSearch;
use App\UsersPush;
use App\UsersPayments;

class SendPush extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
	//
    }

    public function delivery_sms($job, $data)
    {
	$sms = new SmsController;
	$info = $sms->detailReport($data['smsid']);

Log::info(json_encode($info));

	if (isset($info['code']) && $info['code'] == 1) {
	    $search = UsersSearch::find($data['id']);
	    $regs = UsersPush::whereUserId($search->user_id)->get();

	    if ($regs->count() > 0) {
		foreach ($regs as $reg) {
		    if ($reg->system == "android") {
			PushController::android_notification([$reg->regid], [
			    "push_id" 	=> $data["id"],
			    "type"	=> "delivery_sms",
			    "caption"	=> "Отчет от доставке sms",
			    "message"	=> "Ваше sms-сообщение доставлено владельцу автомобиля с гос.номером ".$search->regnumber
			]);
		    }
		    if ($reg->system == "ios") {
			PushController::ios_notification([$reg->regid], [
			    "push_id" 	=> $data["id"],
			    "type"	=> "delivery_sms",
			    "caption"	=> "Отчет от доставке sms",
			    "message"	=> "Ваше sms-сообщение доставлено владельцу автомобиля с гос.номером ".$search->regnumber
			]);
		    }
		}
	    }

	    $job->delete();
	}
	else
    	    $job->release(30);
    }

    public function payment($job, $data)
    {
        $payment = UsersPayments::find($data['id']);
	if ($payment !== null) {
	    $regs = UsersPush::whereUserId($payment->user_id)->get();
	    $user = Users::find($payment->user_id);

    	    if ($regs->count() > 0) {
    		foreach ($regs as $reg) {
	    	    if ($reg->system == "android") {
			PushController::android_notification([$reg->regid], [
			    "push_id" 	=> $data["id"],
			    "type"	=> "payment",
			    "caption"	=> "Пополнение счета",
			    "message"	=> "Ваш счет пополнен на {$payment->balance} рублей. Текущий баланс: {$user->balance} рублей."
			]);
		    }
		}
	    }
	}

	$job->delete();
    }

}
