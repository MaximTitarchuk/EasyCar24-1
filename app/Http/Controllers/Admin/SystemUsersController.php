<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\SystemUsersRequest;

use App\User;
use App\UsersSearch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Facades\Datatables;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\SystemUser;

class SystemUsersController extends Controller
{
    /**
     * Display a listing admin
     *
     * @return Response
     */
    public function index()
    {
        return View('backend.systemusers.users', [
            "is_admin" => 1
        ]);
    }

    /**
     * Display a listing promoter
     *
     * @return Response
     */
    public function promoter()
    {
        return View('backend.systemusers.users', [
            "is_admin" => 0
        ]);
    }

    /**
     * Display a listing users
     *
     * @return Response
     */
    public function data($is_admin) {
        $result = Datatables::collection(
            SystemUser
                ::select([
                    "email",
                    "id",
		            "is_admin"
                ])
                ->whereIsAdmin($is_admin)
                ->get()
        )
        ->addColumn('actions', function($model){
            return
                '<button type="button" class="btn btn-danger btn-rounded btn-sm remove-button pull-right" data-id="'.$model->id.'" style="margin-right: 2px" title="Удалить"><i class="fa fa-remove" aria-hidden="true"></i></button>'.
                '<button type="button" class="btn btn-primary btn-rounded btn-sm edit-button pull-right" data-id="'.$model->id.'" style="margin-right: 2px" title="Изменить"><i class="fa fa-pencil" aria-hidden="true"></i></button>'.
                ($model->is_admin == 0?
                    '<button type="button" class="btn btn-greensea btn-rounded btn-sm stats-button pull-right" data-id="'.$model->id.'" style="margin-right: 2px" title="Статистика"><i class="fa fa-usd" aria-hidden="true"></i></button>&nbsp;':
                    ''
                );
        });

        if ($is_admin == 0) {
            $result->addColumn('balance', function($model){
                return User
                    ::rightJoin("users_payments", "users_payments.user_id", "=", "users.id")
                    ->where("users.system_user_id", "=", $model->id)
                    ->where("users_payments.paid", "=", 1)
                    ->sum("users_payments.balance");
            });
            $result->addColumn('countRef', function($model){
                return User::where("users.system_user_id", "=", $model->id)
                    ->count();
            });
        }
        return $result->make(true);
    }

    /**
     * get info user
     *
     * @return Response
     */
    public function info(Requests\SystemUsersGetInfoRequest $request) {
        return SystemUser
                    ::select([
                        "email",
                        "phone",
                        "is_admin"
                    ])
                    ->find($request->id)
                    ->toJson();
    }

    /**
     * save user data
     *
     * @return Response
     */
    public function save(Requests\SystemUsersSaveRequest $request)
    {
        if ($request->isMethod("put")) {
            $user = SystemUser::find($request->id);
        } else {
            $user = new SystemUser;
        }

        $user->email    = $request->email;
        $user->is_admin = $request->is_admin;
        $user->phone    = $request->phone != ""? preg_replace('/[^0-9]/', '', $request->phone): null;
        if ($request->password != "")
            $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([]);
    }

    /**
     * remove user
     *
     * @param  SystemUsersRequest $request
     * @return Response
     */
    public function remove(Requests\SystemUsersGetInfoRequest $request) {
        SystemUser::find($request->id)->delete();
        return response()->json([]);
    }

    /**
     * get user stats
     *
     * @return Response
     */
    public function stats(Requests\SystemUsersGetInfoRequest $request) {
        $promoter = SystemUser::find($request->id);
        $promoter = User::wherePhone($promoter->phone)->first();

        if ($promoter === null)
            return response("Нет такого пользователя", 422);

        $stats['day'] = [
            "all"       => UsersSearch
                                ::whereUserId($promoter->id)
                                ->whereBetween("created_at", [
                                    Carbon::now()->subDay(),
                                    Carbon::now()
                                ])
                                ->count(),
            "found"     => UsersSearch
                                ::whereUserId($promoter->id)
                                ->whereBetween("created_at", [
                                    Carbon::now()->subDay(),
                                    Carbon::now()
                                ])
                                ->whereFound(true)
                                ->count(),
            "sms"       => UsersSearch
                                ::whereUserId($promoter->id)
                                ->whereBetween("created_at", [
                                    Carbon::now()->subDay(),
                                    Carbon::now()
                                ])
                                ->wherePaid(true)
                                ->whereType("sms")
                                ->count(),
            "call"      => UsersSearch
                                ::whereUserId($promoter->id)
                                ->whereBetween("created_at", [
                                    Carbon::now()->subDay(),
                                    Carbon::now()
                                ])
                                ->wherePaid(true)
                                ->whereType("call")
                                ->count()
        ];

        $stats['all'] = [
            "all"       => UsersSearch
                                ::whereUserId($promoter->id)
                                ->count(),
            "found"     => UsersSearch
                                ::whereUserId($promoter->id)
                                ->whereFound(true)
                                ->count(),
            "sms"       => UsersSearch
                                ::whereUserId($promoter->id)
                                ->wherePaid(true)
                                ->whereType("sms")
                                ->count(),
            "call"      => UsersSearch
                                ::whereUserId($promoter->id)
                                ->wherePaid(true)
                                ->whereType("call")
                                ->count()
        ];

        $stats['day']['percent-found'] = $stats['day']['all'] == 0? 0: number_format($stats['day']['found'] / $stats['day']['all'] * 100, 0);
        $stats['day']['percent-sms'] = $stats['day']['all'] == 0? 0: number_format($stats['day']['sms'] / $stats['day']['all'] * 100, 0);
        $stats['day']['percent-call'] = $stats['day']['all'] == 0? 0: number_format($stats['day']['call'] / $stats['day']['all'] * 100, 0);

        $stats['all']['percent-found'] = $stats['day']['all'] == 0? 0: number_format($stats['all']['found'] / $stats['all']['all'] * 100, 0);
        $stats['all']['percent-sms'] = $stats['day']['all'] == 0? 0: number_format($stats['all']['sms'] / $stats['all']['all'] * 100, 0);
        $stats['all']['percent-call'] = $stats['day']['all'] == 0? 0: number_format($stats['all']['call'] / $stats['all']['all'] * 100, 0);

        $stats['day']['all'] = number_format($stats['day']['all']);
        $stats['day']['sms'] = number_format($stats['day']['sms']);
        $stats['day']['call'] = number_format($stats['day']['call']);

        $stats['all']['all'] = number_format($stats['all']['all']);
        $stats['all']['sms'] = number_format($stats['all']['sms']);
        $stats['all']['call'] = number_format($stats['all']['call']);

        return response()->json(["result" => view('backend.systemusers.promoter_stats', ["stats" => $stats]).""]);
    }

}

