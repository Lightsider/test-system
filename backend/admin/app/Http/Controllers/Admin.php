<?php

namespace App\Http\Controllers;

use App\Quests;
use App\Settings;
use App\TempTesting;
use App\Tests;
use App\Users;
use App\UsersStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Admin extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $testing_time = strtotime(Settings::getByKey("testing_time")->value) ?? 0;
        $current_testing = DB::table("temp_testing")->where("endtime","<",date("d-m-Y",time() + $testing_time))->get()->all();
        $tests_count = Tests::all()->count();
        $quests_count = Quests::all()->count();
        $users_count = Users::all()->count();

        return view('index',[
            "current_testing"=>$current_testing,
            "tests_count"=>$tests_count,
            "quests_count"=>$quests_count,
            "users_count"=>$users_count
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function settings()
    {
        $settings = Settings::getAll(); // custom method
        return view('settings',[
            "settings"=>$settings
        ]);
    }


    /**
     * @param Request $request
     * @return $this
     */
    public function saveSettings(Request $request)
    {
        $testing_time = Settings::getByKey("testing_time");
        $testing_time = Settings::find($testing_time->id);
        $testing_time->value = $request->get("testing_time");
        $testing_time->save();

        return redirect("settings")->with("message", "Настройки успешно изменены");
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function usersList()
    {
        $users = Users::all();
        return view('users',[
            "users"=>$users
        ]);
    }

    public function addOrUpdateUser(Request $request)
    {
        $this->validate($request, [
            'login' => ['string', 'max:255', 'nullable','unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'fullname' => ['string', 'max:255'],
            'group' => ['string', 'max:255', 'nullable'],
            'status' => ['string', 'max:255', 'nullable'],
        ]);

        $user = new Users();
        $user->login=trim($request->login);
        $user->password= Hash::make($request->login);
        $user->fullname=trim($request->login);
        $user->group=str_ireplace(["-","_","'","\""," "],"",mb_strtoupper(trim($request->group)));

        $userStatus = UsersStatus::where("value","=",trim($request->status))->first();
        $user->id_status = $userStatus->id ?? UsersStatus::where("value","=","user")->first()->id;

        $user->save();

        echo json_encode([
            "message"=>"Пользователь ". $user->login ." успешно добавлен"
        ]);
        die();
    }
}
