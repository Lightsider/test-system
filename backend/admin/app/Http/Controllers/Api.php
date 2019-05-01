<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Quests;
use App\Results;
use App\Tests;
use App\TestToCategory;
use App\TestToQuest;
use App\Users;
use App\UsersStatus;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;


class Api extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function usersList()
    {
        return Response::json(Users::with("usersStatus")->select("id", "login", "fullname", "group", "id_status")->get(),
            200,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addUser(Request $request)
    {
        $this->validate($request, [
            'login' => ['string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'fullname' => ['string', 'max:255'],
            'group' => ['string', 'max:255'],
            'status' => ['string', 'max:255'],
        ]);

        $user = new Users();
        $user->login = trim($request->login);
        $user->password = Hash::make($request->password);
        $user->fullname = trim($request->fullname);
        $user->group = str_ireplace(["-", "_", "'", "\"", " "], "", mb_strtoupper(trim($request->group)));

        $userStatus = UsersStatus::where("value", "=", trim($request->status))->first();
        $user->id_status = $userStatus->id ?? UsersStatus::where("value", "=", "user")->first()->id;

        $user->save();

        return Response::json([
            "message" => "Пользователь " . $user->login . " успешно добавлен"
        ],
            200,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUser(Request $request,$id)
    {
        $user = Users::where("id",$request->id)->get()->first();
        if(!empty($request->login) && $user->login===$request->login)
        {
            $this->validate($request, [
                'id' => ['int', 'unique:users'],
                'password' => ['string', 'min:6', 'confirmed','nullable'],
                'fullname' => ['string', 'max:255'],
                'group' => ['string', 'max:255'],
                'status' => ['string', 'max:255'],
            ]);
        }
        else
        {
            $this->validate($request, [
                'id' => ['int', 'unique:users'],
                'login' => ['string', 'max:255', 'unique:users'],
                'password' => ['string', 'min:6', 'confirmed','nullable'],
                'fullname' => ['string', 'max:255'],
                'group' => ['string', 'max:255'],
                'status' => ['string', 'max:255'],
            ]);
        }


        $user->login = trim($request->login) ?? $user->login;
        $user->password = Hash::make($request->password)?? $user->password;
        $user->fullname = trim($request->fullname)?? $user->fullname;
        $user->group = str_ireplace(["-", "_", "'", "\"", " "], "", mb_strtoupper(trim($request->group)))?? $user->group;

        $userStatus = UsersStatus::where("value", "=", trim($request->status))->first();
        $user->id_status = $userStatus->id ?? $user->id_status;

        $user->save();

        return Response::json([
            "message" => "Пользователь " . $user->login . " успешно изменен"
        ],
            200,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param $id
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function getUser($id)
    {
        if (!is_numeric($id)) return false;
        return Response::json(Users::where("id", $id)->with("usersStatus")->get(["id", "login","id_status","group","fullname"])->first(),
            200,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);

    }

    /**
     * @param $id
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function deleteUser($id)
    {
        if (!is_numeric($id)) return false;
        if ($id == 1) return Response::json(["message" => "Первого администратора удалять нельзя"],
            200,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);
        Users::where("id", $id)->get()->first()->delete();
        return Response::json(["message" => "Пользователь успешно удален"],
            200,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);
    }

    /******************************************** TEST ********************************************************/


    /**
     * @param $id
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function getTest($id)
    {
        if (!is_numeric($id)) return false;

        $response["test"] = Tests::with("category")->with("questions")->with("results")->where("id",$id)->get()->first();
        $average_values = null;
        foreach ($response["test"]["results"] as $result)
        {
            $average_values += $result["result"];
        }

        if($average_values!==null) $average_values = $average_values/count($response["test"]["results"]);


        $response["average_value"] = $average_values;

        return Response::json($response,
            200,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addTest(Request $request)
    {
        $this->validate($request, [
            'title' => ['string', 'max:255','required'],
            'description' => ['string'],
            'time' => ['date_format:H:i','required'],
            'category' => ['array','nullable'],
        ]);

        if(
            DB::transaction(function ()
        {
            global $request;
            $test = new Tests();
            $test->title = trim($request->title);
            $test->description = trim($request->description);
            $test->time = trim($request->time);
            $test->save();

            if($request->category)
            {
                $categories = DB::table("categories")->whereIn('id',$request->category)->get();
                foreach ($categories as $category)
                {
                    $testToCategory = new TestToCategory();
                    $testToCategory->id_test = $test->id;
                    $testToCategory->id_category = $category->id;
                    $testToCategory->save();
                }
            }

            return true;


        }) === true
        )
        {
            return Response::json([
                "message" => "Тест " . htmlspecialchars(trim($request->title)) . " успешно добавлен"
            ],
                200,
                ['Content-type' => 'application/json; charset=utf-8'],
                JSON_UNESCAPED_UNICODE);
        }
        else
        {
            return Response::json([
                "message" => "Что-то пошло не так, тест не добавлен."
            ],
                200,
                ['Content-type' => 'application/json; charset=utf-8'],
                JSON_UNESCAPED_UNICODE);
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTest(Request $request,$id)
    {
        $this->validate($request, [
            'id' => ['int', 'required'],
            'title' => ['string', 'max:255','required'],
            'description' => ['string'],
            'time' => ['date_format:H:i','required'],
            'category' => ['array','nullable'],
        ]);

        if(
            DB::transaction(function ()
            {
                global $request;
                $test = Tests::find($request->id);
                $test->title = trim($request->title);
                $test->description = trim($request->description);
                $test->time = trim($request->time);
                $test->save();

                if($request->category)
                {
                    //delete old
                    $oldCategories = DB::table("test_to_category")->where('id_test',$test->id)->get();
                    foreach ($oldCategories as $oldCategory)
                    {
                        TestToCategory::destroy($oldCategory->id);
                    }
                    //add new
                    $categories = DB::table("categories")->whereIn('id',$request->category)->get();
                    foreach ($categories as $category)
                    {
                        $testToCategory = new TestToCategory();
                        $testToCategory->id_test = $test->id;
                        $testToCategory->id_category = $category->id;
                        $testToCategory->save();
                    }
                }

                return true;


            }) === true
        )
        {
            return Response::json([
                "message" => "Тест " . htmlspecialchars(trim($request->title)) . " успешно изменен"
            ],
                200,
                ['Content-type' => 'application/json; charset=utf-8'],
                JSON_UNESCAPED_UNICODE);
        }
        else
        {
            return Response::json([
                "message" => "Что-то пошло не так, тест не добавлен."
            ],
                200,
                ['Content-type' => 'application/json; charset=utf-8'],
                JSON_UNESCAPED_UNICODE);
        }
    }

    public function deleteTest(int $id)
    {
        Tests::findOrFail($id)->delete();
        return Response::json([
            "message" => "Тест успешно удален"
        ],
            200,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function testsList()
    {
        $response["tests"] = Tests::with("category")->with("questions")->with("results")->get();
        $average_values = [];

        foreach ($response["tests"] as $test)
        {
            $average_values[$test->id] = null;
            foreach ($test["results"] as $result)
            {
                $average_values[$test->id] += $result["result"];
            }

            if($average_values[$test->id]!==null) $average_values[$test->id] = $average_values[$test->id]/count($test["results"]);
        }

        $response["average_values"] = $average_values;

        return Response::json($response,
            200,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);
    }


    /******************************************** QUEST ********************************************************/

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function questsForTestList(int $testId=null)
    {
        if($testId!==null && is_numeric($testId))
        {
            $quests = TestToQuest::where("id_test",$testId)->get()->toArray();
            $questArr = [];
            foreach ($quests as $quest)
            {
                $questArr[] = $quest["id_quest"];
            }
            $quests = Quests::with("category")->whereIn("questions.id",$questArr)->get();
            return Response::json($quests,
                200,
                ['Content-type' => 'application/json; charset=utf-8'],
                JSON_UNESCAPED_UNICODE);
        }

        return Response::json(["message"=>"Тест не найден"],
            200,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);
    }

    public function questDetail(int $id)
    {
        if($id!==null && is_numeric($id))
        {
            $quest = Quests::findOrFail($id);
            return Response::json($quest,
                200,
                ['Content-type' => 'application/json; charset=utf-8'],
                JSON_UNESCAPED_UNICODE);
        }

        return Response::json(["message"=>"Вопрос не найден"],
            200,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addQuestToTest(Request $request)
    {
        $this->validate($request, [
            'test-id' => ['int', 'required'],
            'quests' => ['array', 'required'],
        ]);

        if(
            DB::transaction(function ()
            {
                global $request;

                $test_id = $request->get('test-id');
                $quests = $request->quests;
                $oldTestToQuest = TestToQuest::where("id_test",$test_id)->get();
                foreach ($oldTestToQuest as $quest)
                {
                    $quest->delete();
                }
                foreach ($quests as $quest)
                {
                    $testToQuest = new TestToQuest();
                    $testToQuest->id_test = $test_id;
                    $testToQuest->id_quest = $quest;
                    $testToQuest->save();
                }

                return true;


            }) === true
        )
        {
            return Response::json([
                "message" => "Тест успешно изменен"
            ],
                200,
                ['Content-type' => 'application/json; charset=utf-8'],
                JSON_UNESCAPED_UNICODE);
        }
        else
        {
            return Response::json([
                "message" => "Что-то пошло не так, тест не изменен."
            ],
                200,
                ['Content-type' => 'application/json; charset=utf-8'],
                JSON_UNESCAPED_UNICODE);
        }

    }

    public function deleteQuestInTest(int $id_test, int $id_quest)
    {
        if (!is_numeric($id_test) || !is_numeric($id_quest)) return false;

        TestToQuest::where("id_test",$id_test)->where("id_quest",$id_quest)->get()->first()->delete();

        return Response::json([
            "message" => "Вопрос успешно удален из теста"
        ],
            200,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);
    }
}
