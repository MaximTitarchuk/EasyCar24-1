<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
//use App\Http\Requests\UsersRequest;

use App\UsersSearch;
use App\UsersPayments;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\Datatables\Facades\Datatables;

use Illuminate\Http\Request;

use App\User;
use App\UsersComments;
use App\Cars;

use Carbon\Carbon;

class UsersController extends Controller
{

    private $region = [
        "RU-AMU" => " Амурская область",
        "RU-ARK" => " Архангельская область",
        "RU-AST" => " Астраханская область",
        "RU-BEL" => " Белгородская область",
        "RU-BRY" => " Брянская область",
        "RU-VLA" => " Владимирская область",
        "RU-VGG" => " Волгоградская область",
        "RU-VLG" => " Вологодская область",
        "RU-VOR" => " Воронежская область",
        "RU-IVA" => " Ивановская область",
        "RU-IRK" => " Иркутская область",
        "RU-KGD" => " Калининградская область",
        "RU-KLU" => " Калужская область",
        "RU-KEM" => " Кемеровская область",
        "RU-KIR" => " Кировская область",
        "RU-KOS" => " Костромская область",
        "RU-KGN" => " Курганская область",
        "RU-KRS" => " Курская область",
        "RU-LEN" => " Ленинградская область",
        "RU-LIP" => " Липецкая область",
        "RU-MAG" => " Магаданская область",
        "RU-MOS" => " Московская область",
        "RU-MUR" => " Мурманская область",
        "RU-NIZ" => " Нижегородская область",
        "RU-NGR" => " Новгородская область",
        "RU-NVS" => " Новосибирская область",
        "RU-OMS" => " Омская область",
        "RU-ORE" => " Оренбургская область",
        "RU-ORL" => " Орловская область",
        "RU-PNZ" => " Пензенская область",
        "RU-PSK" => " Псковская область",
        "RU-ROS" => " Ростовская область",
        "RU-RYA" => " Рязанская область",
        "RU-SAM" => " Самарская область",
        "RU-SAR" => " Саратовская область",
        "RU-SAK" => " Сахалинская область",
        "RU-SVE" => " Свердловская область",
        "RU-SMO" => " Смоленская область",
        "RU-TAM" => " Тамбовская область",
        "RU-TVE" => " Тверская область",
        "RU-TOM" => " Томская область",
        "RU-TUL" => " Тульская область",
        "RU-TYU" => " Тюменская область",
        "RU-ULY" => " Ульяновская область",
        "RU-CHE" => " Челябинская область",
        "RU-YAR" => " Ярославская область",
        "RU-AD" => " Адыгея",
        "RU-BA" => " Башкортостан",
        "RU-BU" => " Бурятия",
        "RU-DA" => " Дагестан",
        "RU-IN" => " Ингушетия",
        "RU-KB" => " Кабардино-Балкария",
        "RU-KL" => " Калмыкия",
        "RU-KC" => " Карачаево-Черкесия",
        "RU-KR" => " Карелия",
        "RU-ME" => " Марий Эл",
        "RU-MO" => " Мордовия",
        "RU-AL" => " Республика Алтай",
        "RU-KO" => " Республика Коми",
        "RU-SA" => " Республика Саха",
        "RU-SE" => " Северная Осетия",
        "RU-TA" => " Татарстан",
        "RU-TY" => " Тыва",
        "RU-UD" => " Удмуртия",
        "RU-KK" => " Хакасия",
        "RU-CE" => " Чечня",
        "RU-CU" => " Чувашия",
        "RU-ALT" => " Алтайский край",
        "RU-ZAB" => " Забайкальский край",
        "RU-KAM" => " Камчатский край",
        "RU-KDA" => " Краснодарский край",
        "RU-KYA" => " Красноярский край",
        "RU-PER" => " Пермский край",
        "RU-PRI" => " Приморский край",
        "RU-STA" => " Ставропольский край",
        "RU-KHA" => " Хабаровский край",
        "RU-NEN" => " Ненецкий автономный округ",
        "RU-KHM" => " Ханты-Мансийский автономный округ — Югра",
        "RU-CHU" => " Чукотский автономный округ",
        "RU-YAN" => " Ямало-Ненецкий автономный округ",
        "RU-SPE" => " Санкт-Петербург",
        "RU-MOW" => " Москва",
        "RU-YEV" => " Еврейская автономная область"
    ];

    /**
     * Display a listing users
     *
     * @return Response
     */
    public function index()
    {
        return View('backend.users.users');
    }

    public function data()
    {
        return Datatables
		    ::collection(User::with("comments")->select("id", "name", "email", "phone", "created_at", "balance", "ip", "region")->orderBy("email", "asc")->get())
            ->addColumn('actions', function($model){
                return
                    '<button type="button" class="btn btn-primary btn-rounded btn-sm edit-button pull-right" data-id="'.$model->id.'" title="Изменить"><i class="fa fa-pencil" aria-hidden="true"></i></button>'.
                    '<button type="button" class="btn btn-success btn-rounded btn-sm balance-button pull-right" style="margin-right: 10px" data-id="'.$model->id.'" title="Пополнить баланс"><i class="fa fa-money" aria-hidden="true"></i></button>'.
                    '<button type="button" class="btn btn-info btn-rounded btn-sm stats-button pull-right" style="margin-right: 2px" data-id="'.$model->id.'" title="Статистика"><i class="fa fa-bar-chart-o" aria-hidden="true"></i></button>'.
                    '<button type="button" class="btn btn-info btn-rounded btn-sm comments-button pull-right" style="margin-right: 2px" data-id="'.$model->id.'" title="Комментарии к пользователю"><i class="fa fa-comments-o" aria-hidden="true"></i>&nbsp;<strong>'.($model->comments()->count() > 0? $model->comments()->count(): "").'</strong></button>';
            })
            ->addColumn('phone', function($model){
		return '<nobr>'.$model->phone.' <a href="https://yandex.ru/search/?text='.$model->phone.'" class="" target="_blank"><i class="fa fa-question-circle" aria-hidden="true"></i></a></nobr>';
	    })
            ->addColumn('regnumber', function($model){
		$car = Cars::wherePhone($model->phone)->select(["regnumber"])->get();

		return $car->count() === 0? "": $car->implode("regnumber", ", ");
	    })
            ->addColumn('region', function($model){
                return
                    is_null($model->ip)?
                        "Нет данных"
                    :
                        (isset($this->region[$model->region])?
                            trim($this->region[$model->region])." (".long2ip($model->ip).")"
                        :
                            "Регион не определен (".long2ip($model->ip).")"
                        );


            })
		    ->make(true);
    }




    public function balance(Requests\UsersBalanceRequest $request)
    {
        $user = User::find($request->id);

	    $user->balance()->create(["user_id" => $request->id, "balance" => $request->balance, "paid" => true, "description" => "Пополнение через интерфейс администратора ".Auth::user()->email." (".Auth::user()->id.")"]);
	    $user->update(["balance" => $user->balance + $request->balance]);
	    return response()->json(["balance" => $user->balance]);
    }

    /**
     * get info user
     *
     * @return Response
     */
    public function info(Requests\UsersGetInfoRequest $request) {
        return User
            ::select([
                "name",
                "email",
                "phone",
                "is_active",
                "system_user_id"
            ])
            ->find($request->id)
            ->toJson();
    }


    /**
     * save user data
     *
     * @return Response
     */
    public function save(Requests\UsersSaveRequest $request)
    {
        if ($request->isMethod("put")) {
            $user = User::find($request->id);
        } else {
            $user = new User;
        }

        $user->name             = $request->name;
        $user->email            = $request->email;
        $user->phone            = preg_replace('/[^0-9]/', '', $request->phone);
        $user->is_active        = $request->is_active;
        $user->system_user_id   = $request->system_user_id != ""? $request->system_user_id: null;
        $user->save();

        return response()->json([]);
    }

    /**
     * get list users search
     *
     * @return Response
     */
    public function statsSearch(Requests\UsersGetInfoRequest $request) {
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

    /**
     * get user comments
     *
     * @return Response
     */
    public function comments(Requests\UsersGetInfoRequest $request) {
        return response()->json(["content" => View('backend.users.comments', [
	    "comments" => UsersComments
        	::whereUserId($request->id)
	        ->get()
    	    ])->render()
	]);
    }

    /**
     * save new comment
     *
     * @return Response
     */
    public function commentsAdd(Requests\UsersCommentsSaveRequest $request)
    {
	$comment = new UsersComments(['user_id' => $request->user_id, "system_user_id" => Auth::user()->id, 'comment' => $request->comment]);

	User::find($request->user_id)->comments()->save($comment);

        return response()->json([]);
    }

    

}

