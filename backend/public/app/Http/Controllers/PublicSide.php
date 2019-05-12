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
    private function getColorScheme($result, $mode = "color")
    {
        if ($mode === "bootstrap") {
            if (!is_numeric($result)) return "default";
            elseif ($result < 25) {
                return "danger";
            } elseif ($result < 50) {
                return "warning";
            } elseif ($result < 75) {
                return "primary";
            } elseif ($result < 100) {
                return "success";
            } else return "default";
        } else {
            if (!is_numeric($result)) return "default";
            elseif ($result < 25) {
                return "red";
            } elseif ($result < 50) {
                return "yellow";
            } elseif ($result < 75) {
                return "blue";
            } elseif ($result < 100) {
                return "green";
            } else return "default";
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tests = Tests::with('questions')->with("category")->get();

        $average_values = [];
        $user_results = [];

        foreach ($tests as $test) {
            $average_values[$test->id] = null;
            if (count($test["results"]) > 0) $average_values[$test->id]["value"] = 0;
            foreach ($test["results"] as $result) {
                $average_values[$test->id]["value"] += $result["result"];
            }
            if (!empty($average_values[$test->id])) $average_values[$test->id]["value"] = $average_values[$test->id]["value"] / count($test["results"]);
            $average_values[$test->id]["color"] = $this->getColorScheme($average_values[$test->id]["value"]);

            $user_results[$test->id]["value"] = $test->getUserResult(Auth::user()->id)->result;
            $user_results[$test->id]["color"] = $this->getColorScheme($user_results[$test->id]["value"]);
        }

        return view('index', [
            "average_values" => $average_values,
            "user_results" => $user_results,
            "tests" => $tests
        ]);
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function testPreview(int $id)
    {
        $test = Tests::with("results")->findOrFail($id);

        $average_values = null;
        $user_results = null;

        if (count($test["results"]) > 0) $average_values["value"] = 0;
        foreach ($test["results"] as $result) {
            $average_values["value"] += $result["result"];
        }
        if ($average_values !== null) $average_values["value"] = $average_values["value"] / count($test["results"]);
        $average_values["color"] = $this->getColorScheme($average_values["value"]);

        $user_results["value"] = $test->getUserResult(Auth::user()->id)->result;
        $user_results["color"] = $this->getColorScheme($user_results["value"]);

        return view('test_preview', [
            "average_value" => $average_values,
            "user_result" => $user_results,
            "test" => $test
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile()
    {
        $user = Auth::user();

        $average_value["value"] = null;

        $results = Results::with("test")->where("id_user", $user->id)->orderBy("date", "DESC")->get();
        $max_result = $last_result = $results[0] ?? null;

        foreach ($results as $key => $result) {
            if ($result->result > $max_result->result) $max_result = $result;
            $average_value["value"] += $result["result"];
            $results[$key]["color"] = $this->getColorScheme($result["result"], "bootstrap");
        }
        if ($average_value !== null) $average_value["value"] = $average_value["value"] / count($results);


        return view('profile', [
            "average_value" => $average_value,
            "max_result" => $max_result,
            "last_result" => $last_result,
            "results" => $results,
            "user" => $user
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contacts()
    {
        return view('contacts');
    }
}
