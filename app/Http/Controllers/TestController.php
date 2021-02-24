<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TestController extends Controller
{
    public function testUserRegistration() {
        return view('test/userRegistration');
    }
    public function testUserAuth() {
        return view('test/userAuth');
    }
    public function testUserActivate() {
        return view('test/userActivate');
    }
    public function testUserPasswordRecovery() {
        return view('test/passwordRecovery');
    }
    public function testCarsSearch() {
        return view('test/search');
    }
    public function testPayment() {
        return view('test/payment');
    }

    public function testSendSms() {
        return view('test/sendsms');
    }


}
