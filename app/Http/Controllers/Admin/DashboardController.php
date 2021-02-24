<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\SystemUsersRequest;

use App\User;
use App\UsersPayments;
use App\UsersSearch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Facades\Datatables;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\SystemUser;

class DashboardController extends Controller
{
    /**
     * Display a listing admin
     *
     * @return Response
     */
    public function index()
    {
        $userAll = User::count();
        $userAllLastWeek = User::whereBetween("created_at", [Carbon::now()->subWeek(), Carbon::now()])->count();
        $userAllLastWeek2 = User::whereBetween("created_at", [Carbon::now()->subWeek(2), Carbon::now()->subWeek()])->count();

        $userActive = User::whereIsActive(1)->count();
        $userActiveLastWeek = User::whereIsActive(1)->whereBetween("created_at", [Carbon::now()->subWeek(), Carbon::now()])->count();
        $userActiveLastWeek2 = User::whereIsActive(1)->whereBetween("created_at", [Carbon::now()->subWeek(2), Carbon::now()->subWeek()])->count();

        $userInactive = User::whereIsActive(0)->count();
        $userInactiveLastWeek = User::whereIsActive(0)->whereBetween("created_at", [Carbon::now()->subWeek(), Carbon::now()])->count();
        $userInactiveLastWeek2 = User::whereIsActive(0)->whereBetween("created_at", [Carbon::now()->subWeek(2), Carbon::now()->subWeek()])->count();


        $data["users"] = [
            "all"               => number_format($userAll, 0, '.', ' '),
            "allText"           => $this->num2word($userAll, ["пользователь", "пользователя", "пользователей"]),
            "allGrowthWeek"     => $userAllLastWeek2 > $userAllLastWeek? "-".number_format($userAllLastWeek2 > 0? $userAllLastWeek / $userAllLastWeek2 * 100: 0, 2, ".", " "): number_format($userAllLastWeek > 0? $userAllLastWeek2 / $userAllLastWeek * 100: 0, 2, ".", " "),

            "active"            => number_format($userActive, 0, '.', ' '),
            "activeText"        => $this->num2word($userActive, ["активинованный", "активированных", "активированных"]),
            "activeGrowthWeek"  => $userActiveLastWeek2 > $userActiveLastWeek? "-".number_format($userActiveLastWeek2 > 0? $userActiveLastWeek / $userActiveLastWeek2 * 100: 0, 2, ".", " "): number_format($userActiveLastWeek > 0? $userActiveLastWeek2 / $userActiveLastWeek * 100: 0, 2, ".", " "),
            "activePercent"     => number_format($userActive / $userAll * 100, 0),

            "inactive"          => number_format($userInactive, 0, '.', ' '),
            "inactiveText"      => $this->num2word($userInactive, ["не активинованный", "не активированных", "не активированных"]),
            "inactiveGrowthWeek"=> $userInactiveLastWeek2 > $userInactiveLastWeek? "-".number_format($userInactiveLastWeek2 > 0? $userInactiveLastWeek / $userInactiveLastWeek2 * 100: 0, 2, ".", " "): number_format($userInactiveLastWeek > 0? $userInactiveLastWeek2 / $userInactiveLastWeek * 100: 0, 2, ".", " "),
            "inactivePercent"   => number_format($userInactive / $userAll * 100, 0)
        ];

        $search = UsersSearch::count();
        $searchLastWeek = UsersSearch::whereBetween("created_at", [Carbon::now()->subWeek(), Carbon::now()])->count();
        $searchLastWeek2 = UsersSearch::whereBetween("created_at", [Carbon::now()->subWeek(2), Carbon::now()->subWeek()])->count();
        $found  = UsersSearch::whereFound(1)->count();
        $foundLastWeek = UsersSearch::whereFound(1)->whereBetween("created_at", [Carbon::now()->subWeek(), Carbon::now()])->count();
        $foundLastWeek2 = UsersSearch::whereFound(1)->whereBetween("created_at", [Carbon::now()->subWeek(2), Carbon::now()->subWeek()])->count();
        $notfound  = UsersSearch::whereFound(0)->count();
        $notfoundLastWeek = UsersSearch::whereFound(0)->whereBetween("created_at", [Carbon::now()->subWeek(), Carbon::now()])->count();
        $notfoundLastWeek2 = UsersSearch::whereFound(0)->whereBetween("created_at", [Carbon::now()->subWeek(2), Carbon::now()->subWeek()])->count();

        $data["search"] = [
            "all"               => number_format($search, 0, '.', ' '),
            "allText"           => $this->num2word($search, ["запрос", "запроса", "запросов"]),
            "allGrowthWeek"     => $searchLastWeek2 > $searchLastWeek? "-".number_format($searchLastWeek2 > 0? $searchLastWeek / $searchLastWeek2 * 100: 0, 2, ".", " "): number_format($searchLastWeek > 0? $searchLastWeek2 / $searchLastWeek * 100: 0, 2, ".", " "),

            "found"             => number_format($found, 0, '.', ' '),
            "foundText"         => $this->num2word($found, ["найденный запрос", "найденных запроса", "найденных запросов"]),
            "foundGrowthWeek"   => $foundLastWeek2 > $foundLastWeek? "-".number_format($foundLastWeek2? $foundLastWeek / $foundLastWeek2 * 100: 0, 2, ".", " "): number_format($foundLastWeek > 0? $foundLastWeek2 / $foundLastWeek * 100: 0, 2, ".", " "),
            "foundPercent"      => number_format($found / $search * 100, 0),

            "notfound"             => number_format($notfound, 0, '.', ' '),
            "notfoundText"         => $this->num2word($notfound, ["не найденный запрос", "не найденных запроса", "не найденных запросов"]),
            "notfoundGrowthWeek"   => $notfoundLastWeek2 > $notfoundLastWeek? "-".number_format($notfoundLastWeek2 > 0? $notfoundLastWeek / $notfoundLastWeek2 * 100: 0, 2, ".", " "): number_format($notfoundLastWeek > 0? $notfoundLastWeek2 / $notfoundLastWeek * 100: 0, 2, ".", " "),
            "notfoundPercent"      => number_format($notfound / $search * 100, 0),
        ];

        $payment    = UsersPayments::wherePaid(1)->sum("balance");
        $paymentLastWeek = UsersPayments::wherePaid(1)->whereBetween("created_at", [Carbon::now()->subWeek(), Carbon::now()])->sum("balance");
        $paymentLastWeek2 = UsersPayments::wherePaid(1)->whereBetween("created_at", [Carbon::now()->subWeek(2), Carbon::now()->subWeek()])->sum("balance");

        $agregator    = UsersPayments::wherePaid(1)->whereNotNull("data")->sum("balance");
        $agregatorLastWeek = UsersPayments::wherePaid(1)->whereNotNull("data")->whereBetween("created_at", [Carbon::now()->subWeek(), Carbon::now()])->sum("balance");
        $agregatorLastWeek2 = UsersPayments::wherePaid(1)->whereNotNull("data")->whereBetween("created_at", [Carbon::now()->subWeek(2), Carbon::now()->subWeek()])->sum("balance");

        $data["payment"] = [
            "sum"               => number_format($payment, 0, '.', ' '),
            "sumGrowthWeek"     => $paymentLastWeek2 > $paymentLastWeek? "-".number_format($paymentLastWeek2 > 0? $paymentLastWeek / $paymentLastWeek2 * 100: 0, 2, ".", " "): number_format($paymentLastWeek > 0? $paymentLastWeek2 / $paymentLastWeek * 100: 0, 2, ".", " "),
            "agregator"             => number_format($agregator, 0, '.', ' '),
            "agregatorGrowthWeek"   => $agregatorLastWeek2 > $agregatorLastWeek? "-".number_format($agregatorLastWeek2 > 0? $agregatorLastWeek / $agregatorLastWeek2 * 100: 0, 2, ".", " "): number_format($agregatorLastWeek > 0? $agregatorLastWeek2 / $agregatorLastWeek * 100: 0, 2, ".", " "),
        ];

        return View('backend.dashboard.dashboard', [
            "data" => $data
        ]);
    }

    function num2word($num, $words) {
        $num=$num%100;
        if ($num>19) { $num=$num%10; }
        switch ($num) {
            case 1:  { return($words[0]); }
            case 2: case 3: case 4:  { return($words[1]); }
            default: { return($words[2]); }
        }
    }


}

