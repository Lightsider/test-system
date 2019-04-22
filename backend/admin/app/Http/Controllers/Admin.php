<?php

namespace App\Http\Controllers;

use App\Quests;
use App\Settings;
use App\TempTesting;
use App\Tests;
use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;

class Admin extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    index page
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
    settings page
     */
    public function settings()
    {
        $settings = Settings::getAll(); // custom method
        return view('settings',[
            "settings"=>$settings
        ]);
    }

    public function saveSettings(Request $request)
    {
        $testing_time = Settings::getByKey("testing_time");
        $testing_time = Settings::find($testing_time->id);
        $testing_time->value = $request->get("testing_time");
        $testing_time->save();

        return redirect("settings")->with("message", "Настройки успешно изменены");
    }
}
