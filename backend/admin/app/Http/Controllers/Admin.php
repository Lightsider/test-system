<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Quests;
use App\Results;
use App\Settings;
use App\TempTesting;
use App\Tests;
use App\TestToCategory;
use App\TestToQuest;
use App\Users;
use App\UsersStatus;
use Dotenv\Regex\Result;
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
        $current_testing = DB::table("temp_testing")->where("endtime", "<", date("d-m-Y", time() + $testing_time))->get()->all();
        $tests_count = Tests::all()->count();
        $quests_count = Quests::all()->count();
        $users_count = Users::all()->count();

        return view('index', [
            "current_testing" => $current_testing,
            "tests_count" => $tests_count,
            "quests_count" => $quests_count,
            "users_count" => $users_count
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function settings()
    {
        $settings = Settings::getAll(); // custom method
        return view('settings', [
            "settings" => $settings
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
        return view('users', [
            "users" => $users
        ]);
    }

    /**
     * @param $login
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function userProfile($login)
    {
        $user = Users::where("login", $login)->get()->first();
        if (empty($user)) return abort(404);

        $results = Results::where("id_user", $user->id)->get();

        $averageValue = null;
        foreach ($results as $value) {
            $averageValue += $value->result;
        }
        if (!empty($averageValue)) $averageValue = $averageValue / count($results);

        return view('user_profile', [
            "user" => $user,
            "results" => $results,
            "averageValue" => $averageValue
        ]);
    }

    public function testsList()
    {
        $tests = Tests::all();

        $counts_quest = [];
        $averageValues = [];
        $categories = [];
        foreach ($tests as $test) {
            $counts_quest[$test->id] = TestToQuest::where("id_test", $test->id)->get()->count();

            $categories[$test->id] = TestToCategory::where("id",$test->id)->get();
            $tmp_categories="";
            foreach ($categories[$test->id] as $category)
            {
                $tmp_categories .= $category->category->name.",";
            }
            $categories[$test->id] = mb_substr($tmp_categories,0,mb_strlen($tmp_categories)-1);

            $results = Results::where("id_test", $test->id)->get();
            $averageValue = null;

            foreach ($results as $result)
            {
                $averageValue += $result->result;
            }
            if (!empty($averageValue)) $averageValue = $averageValue / count($results);
            $averageValues[$test->id] = $averageValue;
        }

        $allow_categories = Categories::all();
        return view('tests', [
            "categories"=>$categories,
            "average_values"=>$averageValues,
            "counts_quest" => $counts_quest,
            "tests" => $tests,
            "allow_categories" => $allow_categories
        ]);
    }
}
