<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
//use App\Http\Requests\UsersRequest;

use App\UsersSearch;
use App\UsersPayments;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Facades\Datatables;

use Illuminate\Http\Request;

use App\Specials;

use Carbon\Carbon;

class SpecialsController extends Controller
{
    /**
     * Display a listing soecials
     *
     * @return Response
     */
    public function index()
    {
        return View('backend.specials.specials');
    }

    public function data()
    {
        return Datatables
		    ::collection(
                Specials::select("id", "date_from", "date_to", "sum_from", "sum_to", "percent")->orderBy("date_from", "asc")->orderBy("date_to", "asc")->get()
            )
            ->addColumn('actions', function($model){
                return
                    '<button type="button" class="btn btn-primary btn-rounded btn-sm edit-button pull-right" data-id="'.$model->id.'" title="Изменить"><i class="fa fa-pencil" aria-hidden="true"></i></button>&nbsp;';
            })
            ->addColumn('dates', function($model){
                return
                    Carbon::parse($model->date_from)->format("d.m.Y H:i")." &mdash; ".Carbon::parse($model->date_to)->format("d.m.Y H:i");
            })
            ->addColumn('sums', function($model){
                return
                    $model->sum_from." &mdash; ".$model->sum_to;
            })
		    ->make(true);
    }




    /**
     * get info user
     *
     * @return Response
     */
    public function info(Requests\SpecialsGetInfoRequest $request) {
        return Specials
            ::select([
                DB::raw("date_format(date_from, '%d.%m.%Y %H:%i:%s') as date_from"),
                DB::raw("date_format(date_to, '%d.%m.%Y %H:%i:%s') as date_to"),
                "sum_from",
                "sum_to",
                "percent"
            ])
            ->find($request->id)
            ->toJson();
    }


    /**
     * save user data
     *
     * @return Response
     */
    public function save(Requests\SpecialsSaveRequest $request)
    {
        if ($request->isMethod("put")) {
            $special = Specials::find($request->id);
        } else {
            $special = new Specials;
        }

        $special->date_from    = Carbon::parse($request->date_from);
        $special->date_to      = Carbon::parse($request->date_to);
        $special->sum_from     = $request->sum_from;
        $special->sum_to       = $request->sum_to;
        $special->percent      = $request->percent;
        $special->content      = $request->content;
        $special->save();

        return response()->json([]);
    }

    /**
     * get list users search
     *
     * @return Response
     */
    public function statsSearch(Requests\SpeicalsGetInfoRequest $request) {
        return Datatables
            ::collection(
                UsersSearch
                    ::select([
                        "regnumber",
                        "cost",
                        "paid",
                        "found",
                        "type",
                        "created_at"
                    ])
                    ->whereUserId($request->id)
                    ->get()
            )
            ->addColumn('found', function($model){
                return
                    $model->found == 1?
                        '<span class="label bg-success">Найдено</span>'
                        :
                        '<span class="label bg-danger">Не найдено</span>';
            })
            ->addColumn('paid', function($model){
                return
                    $model->found == 0?
                        ''
                        :
                        ($model->paid == 1?
                            '<span class="label bg-success">Оплачено</span>'
                            :
                            '<span class="label bg-warning">Не оплачено</span>');
            })
            ->addColumn('type', function($model){
                return
                    $model->paid != 1?
                        ''
                    :
                        ($model->type == "sms"?
                            '<span class="label bg-primary">SMS</span>'
                            :
                            '<span class="label bg-greensea">Вызов</span>');
            })
            ->addColumn('created_at', function($model){
                return Carbon::parse($model->created_at)->format("d.m.Y H:i:s");
            })
            ->make(true);
    }

    /**
     * get list users payments
     *
     * @return Response
     */
    public function statsPayment(Requests\UsersGetInfoRequest $request) {
        return Datatables
            ::collection(
                UsersPayments
                    ::select([
                        "balance",
                        "paid",
                        "description",
                        "updated_at"
                    ])
                    ->whereUserId($request->id)
                    ->get()
            )
            ->addColumn('paid', function($model){
                return
                    $model->paid == 1?
                        '<span class="label bg-success">Оплачено</span>'
                        :
                        '<span class="label bg-warning">Не оплачено</span>';
            })
            ->addColumn('updated_at', function($model){
                return Carbon::parse($model->updated_at)->format("d.m.Y H:i:s");
            })
            ->make(true);
    }

}

