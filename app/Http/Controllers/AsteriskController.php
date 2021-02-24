<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class AsteriskController extends Controller
{
    private $url            = "http://192.162.242.11:8088/ari/channels";
    private $login          = "easycar";
    private $password       = "234r5kleCfwerf534rtewtfgrewfg";

    public function call($callId, $phone1, $phone2) {
	$socket = fsockopen("192.162.242.11", 5038, $errno, $errstr, 10);
	fputs($socket, "Action: login\r\n" );
	fputs($socket, "Username: easycar\r\n" );
	fputs($socket, "Secret: ed3068676826c03b21a67ec3fd1ebeae\r\n\r\n" );

	fgets($socket);
	fgets($socket);
	fgets($socket);
	fgets($socket);

	fputs($socket, "Action: Originate\r\n" );
	fputs($socket, "Channel: local/{$phone1}@easycar1\r\n" );
	fputs($socket, "Context: easycar2\r\n" );
	fputs($socket, "Exten: {$phone2}\r\n" );
	fputs($socket, "Priority: 1\r\n" );
	fputs($socket, "Timeout: 30000\r\n" );
	fputs($socket, "Callerid: 060957500\r\n" );
	fputs($socket, "Variable: ActionID={$callId}\r\n\r\n" );

	fgets($socket);
	fgets($socket);
	fgets($socket);
	fgets($socket);

	return;

        $post = [
            "channelId"         => "local/{$phone1}@easycar1",
            "extension"         => $phone2,
            "context"           => "easycar2",
            "priority"          => 1,
            "callerId"          => "060957500",
            "endpoint"          => "local/{$phone1}@easycar1",
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url."/".$callId);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
        curl_setopt($ch, CURLOPT_USERPWD, "{$this->login}:{$this->password}");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                            'Content-Type: application/json',
                            'Accept: application/json',
                            'User-Agent: php-ari'
                        ]);

        $result = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

	if ($code != 200)
	    return false;
	return true;
    }
}