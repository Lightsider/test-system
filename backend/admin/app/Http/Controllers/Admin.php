<?php

namespace App\Http\Controllers;

use App\Quests;
use App\TempTesting;
use App\Tests;
use App\Users;
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

        $current_testing = DB::table("temp_testing")->where("endtime","<",date("d-m-Y",time() + 86400))->get()->all();
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
}
