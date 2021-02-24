<?php

namespace App\Http\Controllers;

use App\Cars;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Http\Requests;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;

class UploadBaseController extends Controller
{
    public function uploadBase($filename)
    {
        if (!file_exists(storage_path("bases/").$filename))
            abort(404);
    
	$count = 0;

        $fp = fopen(storage_path("bases/").$filename, "r");
        while (!feof($fp)) {
            $data = trim(str_replace("\"", "", fgets($fp)));

            if ($data == "")
                continue;

            $data = explode("\t", $data);

            if (count($data) != 2)
                continue;

            list($number, $phone) = $data;

            $validator = Validator::make(
                [
                    'number' => $number,
                    "phone" => $phone
                ],
                [
                    'phone' => [
                        "required",
                        "regex:/^((8|\+?7)?(\d){10})$/"
                    ],
                    'number' => [
                        "required",
                        "unique:cars,regnumber",
                        "regex:/^[АВЕКМНОРСТУХ]{2}[0-9]{3}[АВЕКМНОРСТУХ]{4}[0-9]{2,3}$/i"
                    ]
                ]
            );

            if ($validator->fails()) {
                continue;
            }

            $seriesDB = mb_substr($number, 0, 1).mb_substr($number, 4, 2);
            $numberDB = mb_substr($number, 1, 3);
            $regionDB = mb_substr($number, 6);

            if (mb_strlen($phone) != 10)
                if (mb_substr($phone, 0, 1) == "8" || mb_substr($phone, 0, 1) == "7")
                    $phone = mb_substr($phone, 1);
                else
                    $phone = mb_substr($phone, 2);
				
			if (mb_strlen($phone) != 10)
				continue;


            Cars::create([
                "phone"     => $phone,
                "regnumber" => $number,
                "series"    => $seriesDB,
                "number"    => (string) $numberDB,
                "region"    => $regionDB
            ]);

            unset($validator);

	    $count++;

	    if ($count % 1000 == 0)
		echo date("H:i:s")."\t".$count."<BR>";
        }

        dd("end");
    }
	
    public function uploadToSqlBase($filename)
    {
        if (!file_exists(storage_path("bases/").$filename))
            abort(404);
    
	$count = 0;

        $fp = fopen(storage_path("bases/").$filename, "r");
        while (!feof($fp)) {
		
	    if ($count % 300000 == 0)
			$out = fopen(storage_path("bases/").$filename."-".($count/300000)."-".".out", "w");
		
	    $count++;

	    if ($count % 1000 == 0) {
			Log::info($count);
			echo date("H:i:s")."\t".$count."<BR>";
			flush();
		}

            $data = trim(str_replace("\"", "", fgets($fp)));

            if ($data == "")
                continue;

            $data = explode(";", $data);

            if (count($data) != 2)
                continue;

            list($number, $phone) = $data;

            $validator = Validator::make(
                [
                    'number' => $number,
                    "phone" => $phone
                ],
                [
                    'phone' => [
                        "required",
                        "regex:/^((8|\+?7)?(\d){10})$/"
                    ],
                    'number' => [
                        "required",
                        "unique:cars,regnumber",
                        "regex:/^[АВЕКМНОРСТУХ]{2}[0-9]{3}[АВЕКМНОРСТУХ]{4}[0-9]{2,3}$/i"
                    ]
                ]
            );

            $seriesDB = mb_substr($number, 0, 1).mb_substr($number, 4, 2);
            $numberDB = mb_substr($number, 1, 3);
            $regionDB = mb_substr($number, 6);

            if (mb_strlen($phone) != 10)
                if (mb_substr($phone, 0, 1) == "8" || mb_substr($phone, 0, 1) == "7")
                    $phone = mb_substr($phone, 1);
                else
                    $phone = mb_substr($phone, 2);
				
			if (mb_strlen($phone) != 10)
				continue;

			fwrite($out, "insert into `cars` (phone, regnumber, series, number, region, created_at, updated_at) VALUES ('{$phone}', '{$number}', '{$seriesDB}', '".((string)$numberDB)."', '{$regionDB}', '".Carbon::now()->format("Y-m-d H:i:s")."', '".Carbon::now()->format("Y-m-d H:i:s")."');\n");

            unset($validator);
        }

        dd("end");
    }
}
