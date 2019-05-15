<?php

namespace App\Http\Controllers;

use App\Results;
use App\TempTesting;
use App\Tests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Mockery\Exception;

class PublicSide extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('testing');
    }


    /************************************FUNCTIONS****************************************/

    /**
     * @param $result
     * @param string $mode
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




    /************************************ROUTES****************************************/

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

            $user_results[$test->id]["value"] = $test->getUserResult(Auth::user()->id);
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


        $user_results["value"] = $test->getUserResult(Auth::user()->id);
        $user_results["color"] = $this->getColorScheme($user_results["value"]);

        return view('test_preview', [
            "average_value" => $average_values,
            "user_result" => $user_results,
            "test" => $test
        ]);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function startTest(int $id)
    {
        $test = Tests::with("questions")->findOrFail($id);

        $tmp_test = new TempTesting();
        $tmp_test->id_user = Auth::user()->id;
        $tmp_test->id_test = $test->id;

        $quests = $test->questions->toArray();
        shuffle($quests);
        $arr_quest = [];
        foreach ($quests as $quest) {
            $arr_quest[$quest['id']]["score"] = 0;
            $arr_quest[$quest['id']]["answered"] = 0;
        }
        $tmp_test->quest_arr = json_encode($arr_quest);
        $tmp_test->skip_quest_arr = json_encode([]);
        $tmp_test->id_current_quest = $quests[0]['id'];

        $data_array = date_parse($test->time);
        $tmp_test->endtime = date("Y-m-d H:i:s", strtotime("+" . $data_array["hour"] . " hours +" . $data_array["minute"] . "minutes +" .
            $data_array["second"] . " seconds"));

        $tmp_test->save();

        return redirect("testing");
    }

    public function testing()
    {
        $user = Auth::user();
        $temp_testing = TempTesting::where("id_user", $user->id)->get()->first();
        if (!$temp_testing->isTestingProcessing())
        {
            if(!empty($temp_testing))
            {
                $temp_testing->stopTesting();
                $temp_testing->delete();
            }
            return redirect("/");
        }

        $a_keys = array_keys((array)$temp_testing->quest_arr);
        $current_quest_number = array_search($temp_testing->id_current_quest, $a_keys) + 1;

        $images = [];
        if (!empty($temp_testing->quest->files)) {
            foreach ($temp_testing->quest->files as $file) {
                $mime = mime_content_type($file->path);
                if(strpos($mime,"image")!==false) $images[] = $file;
            }
        }

        $answers = [];
        if($temp_testing->quest->type==="mch" or $temp_testing->quest->type==="ch")
        {
            $answers = $temp_testing->quest->answers->toArray();
            shuffle($answers);
        }

        return view('testing', [
            'answers'=>$answers,
            'images' => $images,
            "current_quest_number" => $current_quest_number,
            "temp_testing" => $temp_testing
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
        $max_result = $last_result = $results[0]!==null ?$results[0]: null;

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
     * @param Request $request
     * @return $this
     */
    public function saveProfile(Request $request)
    {
        $this->validate($request, [
            'fullname' => ['string', 'min:7', 'max:255', 'required'],
            'group' => ['string', 'min:2', 'max:255', 'required'],
        ]);

        if (!empty($request->password)) {
            $this->validate($request, [
                'password' => ['required', 'string', 'min:6', 'confirmed']
            ]);
        }

        try {

            $user = Auth::user();
            $user->fullname = $request->fullname;
            $user->group = $request->group;
            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            return redirect("profile")->with(["message" => "Профиль успешно сохранен"]);
        } catch (Exception $e) {
            return redirect("profile")->withErrors(["saveProfile" => "Ошибка сохранения профиля - " . $e->getMessage()]);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contacts()
    {
        return view('contacts');
    }
}
