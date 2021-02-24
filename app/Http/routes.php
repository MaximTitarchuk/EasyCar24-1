<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
    Route::get('android', function () {
        \App\Http\Controllers\PushController::android_notification("APA91bHTM__jWz9z2zcmUFSG1GRxEDmXhvYz-KvVM12l1c_XLfVGzvepXEJJaZ03sEUElX0WgxsTkQP57H9JE_YtDOaBU84YRO_PkPrONuB1vjADgzmzmNIAKAD0ZCaor-iTy_Z7JWYx", [
	    "push_id"	=> 111,
	    "type"	=> "delivery_sms",
	    "caption"	=> "test",
	    "message"	=> "message"
	]);
    });

Route::group(['domain' => 'root.'.parse_url(config("app.url"))['host'], 'middleware' => ['auth.basic']], function () {
    Route::get('/', function () {
        return redirect("/users");
    });

    Route::group(['prefix' => 'systemusers', 'middleware' => ['access:1']], function() {
        Route::get('', 'Admin\SystemUsersController@index');
        Route::get('promoter', 'Admin\SystemUsersController@promoter');
        Route::get('data/{is_admin}', 'Admin\SystemUsersController@data');
        Route::get('info', 'Admin\SystemUsersController@info');
        Route::get('stats', 'Admin\SystemUsersController@stats');
        Route::match(['post', 'put'], 'save', 'Admin\SystemUsersController@save');
        Route::delete('delete', 'Admin\SystemUsersController@remove');
    });

    Route::group(['prefix' => 'users', 'middleware' => ['access:1']], function() {
        Route::get('', 'Admin\UsersController@index');
        Route::get('data', 'Admin\UsersController@data');
        Route::get('balance', 'Admin\UsersController@balance');
        Route::get('info', 'Admin\UsersController@info');
        Route::match(['post', 'put'], 'save', 'Admin\UsersController@save');

        Route::get('comments', 'Admin\UsersController@comments');
        Route::post('comments/add', 'Admin\UsersController@commentsAdd');

        Route::get('stats/search', 'Admin\UsersController@statsSearch');
        Route::get('stats/payment', 'Admin\UsersController@statsPayment');
    });

    Route::group(['prefix' => 'promo', 'middleware' => ['access:0']], function() {
        Route::get('', 'Admin\PromoController@index');
        Route::get('data', 'Admin\PromoController@data');
    });

    Route::group(['prefix' => 'dashboard', 'middleware' => ['access:1']], function() {
        Route::get('', 'Admin\DashboardController@index');
    });

    Route::group(['prefix' => 'specials', 'middleware' => ['access:1']], function() {
        Route::get('', 'Admin\SpecialsController@index');
        Route::get('data', 'Admin\SpecialsController@data');
        Route::get('info', 'Admin\SpecialsController@info');
        Route::match(['post', 'put'], 'save', 'Admin\SpecialsController@save');
        Route::delete('delete', 'Admin\SpecialsController@remove');
    });

    Route::get('exit', function() {
        Auth::logout();
        Session::flush();
        return redirect("/");
    });

});

Route::group(['domain' => 'system.ksri.info', 'middleware' => ['web']], function () {
    Route::group(['prefix' => 'system'], function () {
        Route::any('', function() {
	    return json_encode(["build" => config("app.build"), "domains" => config("app.domains"), "cost" => ["sms" => config("app.cost_sms"), "call" => config("app.cost_call")]]);
	});
    });
    Route::any('{url?}', function() {
        abort(404);
    })->where("url", "[A-Za-z0-9А-Яа-я\/\\\-_]");
});

Route::group(['middleware' => ['web']], function () {
    Route::get('/', function () {
	    return view('welcome');
    });

//    Route::get('222', function () {
//        $geo = new App\Http\Controllers\GeoIPController(storage_path()."/SxGeoCity.dat");
//        $ip = $_SERVER['REMOTE_ADDR'];
//
//        dd($geo->getCityFull($ip)['region']['iso']);
//    });

    Route::get('payment/{phone?}', function () {
	    return view('payment', [
            "specials"  => \App\Specials
                                ::where("date_from", "<=", Carbon\Carbon::now())
                                ->where("date_to", ">=", Carbon\Carbon::now())
                                ->first()
        ]);
    })->where("phone", "[0-9]{10}");

    Route::any('payment/{state}', function () {
	    return view('payment_success_fail');
    })->where("state", "(success|fail)");

    Route::post('payment', 'V1\PaymentController@addPayment');

//    Route::get('ctest', function () {
//	return view('search');
//    });
    Route::get('download/{file}', function ($file) {
	if (File::exists(storage_path("download/").$file))
	    return response()->download(storage_path("download/").$file);
	abort(404);
    });
    Route::get('download', function () {
//        return redirect("https://play.google.com/store/apps/details?id=ksri.info.easycar24");
	return view('download');
    });
});

Route::group(['prefix' => 'test'], function () {
    Route::get('users/registration', 'TestController@testUserRegistration');
    Route::get('users/auth', 'TestController@testUserAuth');
    Route::get('users/recovery', 'TestController@testUserPasswordRecovery');
    Route::get('users/activate', 'TestController@testUserActivate');
    Route::get('cars/search', 'TestController@testCarsSearch');
    Route::get('cars/sendsms', 'TestController@testSendSms');
    Route::get('payments/payment', 'TestController@testPayment');
});

Route::get('upload/{filename}', 'UploadBaseController@uploadBase');
#Route::get('uploadtosql/{filename}', 'UploadBaseController@uploadToSqlBase');

Route::group(['prefix' => 'api', 'middleware' => ['web']], function () {
    Route::group(['prefix' => 'v1'], function () {
        Route::group(['prefix' => 'cars'], function () {
            Route::post('search', 'V1\CarsController@apiSearchRegNumber');
            Route::post('sendsms', 'V1\CarsController@apiSendSms');
            Route::post('search2', 'V1\CarsController@apiSearchRegNumber2');
        });
        Route::group(['prefix' => 'users'], function () {
            Route::post('registration', 'V1\UsersController@apiUserRegistation');
            Route::post('auth', 'V1\UsersController@apiUserAuth');
            Route::post('activate', 'V1\UsersController@apiUserActivate');
            Route::post('recovery', 'V1\UsersController@apiUserPasswordRecovery');
            Route::post('balance', 'V1\UsersController@apiUserBalance');
            Route::post('reactive', 'V1\UsersController@apiUserSendActivateCode');
            Route::post('regappl', 'V1\UsersController@apiUserRegistrationApplication');
        });
        Route::group(['prefix' => 'payments'], function () {
            Route::post('payment', 'V1\PaymentController@apiPayment');
        });

        Route::group(['prefix' => 'calls'], function () {
            Route::post('call', 'V1\CallController@apiConnectionPhones');
	    Route::match(['post', 'get'], 'call/{callid}', 'V1\CallController@apiUpdateStatus');
        });

        Route::group(['prefix' => 'system'], function () {
            Route::post('', function() {
		return json_encode(["build" => config("app.build"), "domains" => config("app.domains")]);
	    });
        });
    });
});


Route::group(['domain' => 'api.'.parse_url(config("app.url"))['host'], 'middleware' => ['web']], function () {
    Route::group(['prefix' => 'v1'], function () {
        Route::group(['prefix' => 'cars'], function () {
            Route::post('search', 'V1\CarsController@apiSearchRegNumber');
            Route::post('sendsms', 'V1\CarsController@apiSendSms');
            Route::post('search2', 'V1\CarsController@apiSearchRegNumber2');
        });
        Route::group(['prefix' => 'users'], function () {
            Route::post('registration', 'V1\UsersController@apiUserRegistation');
            Route::post('auth', 'V1\UsersController@apiUserAuth');
            Route::post('activate', 'V1\UsersController@apiUserActivate');
            Route::post('recovery', 'V1\UsersController@apiUserPasswordRecovery');
            Route::post('balance', 'V1\UsersController@apiUserBalance');
            Route::post('reactive', 'V1\UsersController@apiUserSendActivateCode');
            Route::post('regappl', 'V1\UsersController@apiUserRegistrationApplication');
        });
        Route::group(['prefix' => 'payments'], function () {
            Route::post('payment', 'V1\PaymentController@apiPayment');
        });
        Route::group(['prefix' => 'calls'], function () {
            Route::post('call', 'V1\CallController@apiConnectionPhones');
	    Route::match(['post', 'get'], 'call/{callid}', 'V1\CallController@apiUpdateStatus');
        });
        Route::group(['prefix' => 'system'], function () {
            Route::post('', function() {
		return json_encode(["build" => config("app.build"), "domains" => config("app.domains"), "cost" => ["sms" => config("app.cost_sms"), "call" => config("app.cost_call")]]);
	    });
        });
        Route::get('stats', 'V1\StatsController@apiStats');
    });

    Route::any('', function() {
	abort(404);
    });    
});


//
//Route::get('/home', 'HomeController@index');
