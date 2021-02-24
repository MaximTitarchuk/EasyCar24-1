<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Requests;

class PushController extends Controller
{
    static $ios_cert = "/var/www/easycar24.ru/www/easycar24.ru/storage/keys/ios.pem";
    static $ios_cafile = "/var/www/easycar24.ru/www/easycar24.ru/storage/keys/ca.pem";
    static $ios_pass = "123456";
/*
Структура $data
push_id: ID уведомления (уникальный в системе для конкретного сообщения)
type: Тип сообщения (delivery_sms, payment)
caption: Заголовок сообщения (может отсутствовать)
message: Сообщение
*/    
    static function android_notification($registatoin_ids, $data) {
        Log::info('android_notification');

        $url = 'https://android.googleapis.com/gcm/send';

        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $data,
        );

        $headers = array(
            'Authorization: key=' . "AIzaSyDM94J4o4qqqf16_cePJBjoey-g79SdFB4",
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
	    Log::info('Curl failed: ' . curl_error($ch));
            die('Curl failed: ' . curl_error($ch));
        }

	Log::info('result: '.$result);

        // Close connection
        curl_close($ch);
        return $result;
    }

    static function ios_notification($registatoin_ids, $data) {
	$ctx = stream_context_create();
Log::info("ios push", $data);
	stream_context_set_option($ctx, 'ssl', 'local_cert', self::$ios_cert);
	stream_context_set_option($ctx, 'ssl', 'passphrase', self::$ios_pass);

	$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 3, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

	if (!$fp) {
	    Log::info('iOS push: удаленный сервер не доступен');
	    return false;
	}

	$body['aps'] = $data;

	$body['aps'] = array(
            'alert' => array (
                'body' => (isset($data['caption']) && $data['caption'] != ""? $data['caption'].". ": "").$data['message'],
            ),
            'sound' => 'default'
	);

	// Encode the payload as JSON
	$payload = json_encode($body);

	// Build the binary notification

	foreach ($registatoin_ids as $token) {
    	    $msg = chr(0) . pack('n', 32) . pack('H*', $token) . pack('n', strlen($payload)) . $payload;
    	    // Send it to the server
	    $result = fwrite($fp, $msg, strlen($msg));
	}

	fclose($fp);

	return $result;
    }
}