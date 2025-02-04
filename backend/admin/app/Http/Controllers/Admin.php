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
        //$testing_time = strtotime(Settings::getByKey("testing_time")->value) ?? 0;
        $current_testing = TempTesting::all()->groupBy("id_test");
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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function endAllTesting()
    {
        $temp_testings = TempTesting::all();
        foreach ($temp_testings as $temp_testing)
        {
            $temp_testing->delete();
        }

        return redirect("/");
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function results()
    {
        $results = Results::all(); // custom method
        return view('results', [
            "results" => $results
        ]);
    }


    /**
     * @param Request $request
     * @return $this
     */
    public function saveSettings(Request $request)
    {
        /*$testing_time = Settings::getByKey("testing_time");
        $testing_time = Settings::find($testing_time->id);
        $testing_time->value = $request->get("testing_time");
        $testing_time->save();*/

        DB::transaction(function () {
            global $request;
            $settings = Settings::all();
            foreach ($settings as $setting) {
                $setting->value = $request->get($setting->key) ?? "no";
                $setting->save();
            }
        });

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
        if (!empty($averageValue)) $averageValue = round($averageValue / count($results),2);

        return view('user_profile', [
            "user" => $user,
            "results" => $results,
            "averageValue" => $averageValue
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function testsList()
    {
        $allow_categories = Categories::all();
        $types = Tests::getTypes();
        return view('tests', [
            "allow_categories" => $allow_categories,
            'types'=>$types
        ]);
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function testDetail(int $id)
    {
        $test = Tests::with(["results"=> function($query){
            $query->orderBy('date', 'desc');
        }])->findOrFail($id);
        $quests = Quests::all();
        $types = Tests::getTypes();
        $allow_categories = Categories::all();
        return view('test_detail', [
            "test" => $test,
            "allow_quests" => $quests,
            "allow_categories" => $allow_categories,
            'types'=>$types
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function questsList()
    {
        $allow_categories = Categories::all();
        $types = Quests::getTypes();
        return view('quests', [
            "allow_categories" => $allow_categories,
            'types'=>$types
        ]);
    }

    public function questDetail(int $id)
    {
        $quest = Quests::findOrFail($id);
        $types = Quests::getTypes();
        $allow_categories = Categories::all();
        return view('quest_detail', [
            "quest"=>$quest,
            "allow_categories" => $allow_categories,
            'types'=>$types
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function support()
    {
        return view('support');
    }
}
