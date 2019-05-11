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

class PublicSide extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $result
     * @return string
     */
    private function getColorScheme($result)
    {
        if(!is_numeric($result)) return "default";
        elseif($result < 25)
        {
            return "red";
        }
        elseif($result < 50)
        {
            return "yellow";
        }
        elseif(!$result < 75)
        {
            return "blue";
        }
        elseif($result < 100)
        {
            return "green";
        }
        else return "default";
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tests = Tests::with('questions')->with("category")->get();

        $average_values = [];
        $user_results = [];

        foreach ($tests as $test)
        {
            $average_values[$test->id] = null;
            foreach ($test["results"] as $result)
            {
                $average_values[$test->id] += $result["result"];
            }
            if($average_values[$test->id]!==null) $average_values[$test->id]["value"] = $average_values[$test->id]/count($test["results"]);
            $average_values[$test->id]["color"] = $this->getColorScheme($average_values[$test->id]["value"]);

            $user_results[$test->id]["value"]=$test->getUserResult(Auth::user()->id);
            $user_results[$test->id]["color"] = $this->getColorScheme( $user_results[$test->id]["value"]);
        }

        return view('index', [
            "average_values"=>$average_values,
            "user_results"=>$user_results,
            "tests" => $tests
        ]);
    }
    //todo СДЕЛАТЬ НАСТРОЙКУ ДЛЯ ВКЛЮЧЕНИЯ РЕГИСТРАЦИИ

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contacts()
    {
        return view('contacts');
    }
}
