<?php

namespace App\Http\Controllers;

use App\Answers;
use App\Categories;
use App\DockerContainers;
use App\Files;
use App\Quests;
use App\QuestToCategory;
use App\Settings;
use App\Tests;
use App\TestToCategory;
use App\TestToQuest;
use App\Users;
use App\UsersStatus;
use Illuminate\Filesystem\Filesystem;
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

        if($average_values!==null) $average_values = round($average_values/count($response["test"]["results"]),2);


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
            'type' => ['string', 'max:255','required'],
        ]);

        if(
            DB::transaction(function ()
            {
                global $request;
                $test = Tests::find($request->id);
                $test->title = trim($request->title);
                $test->description = trim($request->description);
                $test->time = trim($request->time);
                $test->type = trim($request->type);
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

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */

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
        $response["tests"] = Tests::with("category")->with("questions")->with("results")->orderBy("id","desc")->get();
        $average_values = [];

        foreach ($response["tests"] as $test)
        {
            $average_values[$test->id] = null;
            foreach ($test["results"] as $result)
            {
                $average_values[$test->id] += $result["result"];
            }

            if($average_values[$test->id]!==null) $average_values[$test->id] = round($average_values[$test->id]/count($test["results"]),2);
        }

        $response["average_values"] = $average_values;

        return Response::json($response,
            200,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);
    }


    /******************************************** QUEST ********************************************************/

    public function questsList()
    {
        $quests = Quests::with("category")->orderBy("id","desc")->get();

        return Response::json($quests,
            200,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);
    }
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
            $quest = Quests::with("files")->with("category")->with("answers")->with('docker')->findOrFail($id);
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

    /**
     * @param int $id_test
     * @param int $id_quest
     * @return bool|\Illuminate\Http\JsonResponse
     */
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


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addQuest(Request $request)
    {
        $this->validate($request, [
            'title' => ['string', 'max:255','required'],
            'description' => ['string','required'],
            'type' => ['string','required'],
            'hint' => ['string','nullable'],
            'score' => ['int','required',"min:1","max:5"],
            'file.*' => ['file','nullable'],
            'category' => ['array','nullable'],
        ]);

        if(
            DB::transaction(function ()
            {
                global $request;
                $quest = new Quests();
                $quest->title = trim($request->title);
                $quest->description = trim($request->description);
                $quest->score = trim($request->score);
                $quest->type = trim($request->type);
                $quest->hint = trim($request->hint);
                $quest->save();

                $files = $request->file('files');

                if($request->hasFile('files'))
                {
                    foreach ($files as $file) {
                        $destinationPath = Settings::where("key","upload_file_path")->get()->first()->value;
                        $filePath = $file->store($destinationPath);

                        $newFile = new Files();
                        $newFile->path = $filePath;
                        $newFile->id_quest = $quest->id;
                        $newFile->save();
                    }
                }

                if($request->categories)
                {
                    $categories = DB::table("categories")->whereIn('id',$request->categories)->get();
                    foreach ($categories as $category)
                    {
                        $questToCategory = new QuestToCategory();
                        $questToCategory->id_quest = $quest->id;
                        $questToCategory->id_category = $category->id;
                        $questToCategory->save();
                    }
                }

                //create answers
                switch ($quest->type)
                {
                    case "wch":
                        $answer = new Answers();
                        $this->validate($request, [
                            'ans-wch' => ['string','required'],
                        ]);

                        $answer->id_quest = $quest->id;
                        $answer->text = $request->get("ans-wch");
                        $answer->status = "1";
                        $answer->save();
                        break;
                    case "mch":
                        $i=1;
                        while (!empty($request->get("ans-".$i."-mch")))
                        {
                            $this->validate($request, [
                                "ans-".$i."-mch" => ['string','required'],
                                "ans-right-mch-".$i=> ['string'],
                            ]);
                            $answer = new Answers();
                            $answer->id_quest = $quest->id;
                            $answer->text = $request->get("ans-".$i."-mch");
                            if( !empty($request->get("ans-right-mch-".$i)))
                                $answer->status = "1";
                            else
                                $answer->status = "0";
                            $answer->save();
                            $i++;
                        }
                        break;
                    case "doc":
                        $answer = new Answers();
                        $this->validate($request, [
                            'ans-doc' => ['string','required'],
                            'doc-name' => ['string','required','unique:docker_containers,name'],
                        ]);
                        $answer->id_quest = $quest->id;
                        $answer->text = $request->get("ans-doc");
                        $answer->status = "1";
                        $answer->save();

                        $docker = new DockerContainers();
                        $docker->id_quest = $quest->id;
                        $docker->name = $request->get("doc-name");
                        $docker->save();
                        break;
                    case "ch":
                        $i=1;
                        while (!empty($request->get("ans-".$i."-ch")))
                        {
                            $this->validate($request, [
                                "ans-".$i."-ch" => ['string','required'],
                                "ans-right-ch" => ['string','required'],
                            ]);
                            $answer = new Answers();
                            $answer->id_quest = $quest->id;
                            $answer->text = $request->get("ans-".$i."-ch");
                            if( !empty($request->get("ans-right-ch")) && $request->get("ans-right-ch")==$i)
                                $answer->status = "1";
                            else
                                $answer->status = "0";
                            $answer->save();
                            $i++;
                        }
                        break;
                    default:
                        return false;
                }


                return true;


            }) === true
        )
        {
            return Response::json([
                "message" => "Вопрос " . htmlspecialchars(trim($request->title)) . " успешно добавлен"
            ],
                200,
                ['Content-type' => 'application/json; charset=utf-8'],
                JSON_UNESCAPED_UNICODE);
        }
        else
        {
            return Response::json([
                "message" => "Что-то пошло не так, вопрос не добавлен."
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
    public function updateQuest(Request $request)
    {
        $this->validate($request, [
            'id' => ['int', 'required'],
            'title' => ['string', 'max:255','required'],
            'description' => ['string','required'],
            'type' => ['string','required'],
            'hint' => ['string','nullable'],
            'score' => ['int','required',"min:1","max:5"],
            'file.*' => ['file','nullable'],
            'category' => ['array','nullable'],
        ]);

        if(
            DB::transaction(function ()
            {
                global $request;
                $quest = Quests::findOrFail($request->id);
                $quest->title = trim($request->title);
                $quest->description = trim($request->description);
                $quest->score = trim($request->score);
                $quest->type = trim($request->type);
                $quest->hint = trim($request->hint);
                $quest->save();

                $files = $request->file('files');

                if($request->hasFile('files'))
                {
                    foreach ($files as $file) {
                        $destinationPath = Settings::where("key","upload_file_path")->get()->first()->value;
                        $filePath = $file->store($destinationPath);

                        $newFile = new Files();
                        $newFile->path = $filePath;
                        $newFile->id_quest = $quest->id;
                        $newFile->save();
                    }
                }

                if($request->categories)
                {
                    //delete old
                    $oldCategories = DB::table("quest_to_category")->where('id_quest',$quest->id)->get();
                    foreach ($oldCategories as $oldCategory)
                    {
                        QuestToCategory::destroy($oldCategory->id);
                    }
                    //add new
                    $categories = DB::table("categories")->whereIn('id',$request->categories)->get();
                    foreach ($categories as $category)
                    {
                        $questToCategory = new QuestToCategory();
                        $questToCategory->id_quest = $quest->id;
                        $questToCategory->id_category = $category->id;
                        $questToCategory->save();
                    }
                }

                //delete old answers
                $oldAnswers = Answers::where("id_quest",$quest->id)->get();
                foreach ($oldAnswers as $oldAnswer)
                {
                    Answers::destroy($oldAnswer->id);
                }
                //create answers
                switch ($quest->type)
                {
                    case "wch":
                        $answer = new Answers();
                        $this->validate($request, [
                            'ans-wch' => ['string','required'],
                        ]);

                        $answer->id_quest = $quest->id;
                        $answer->text = $request->get("ans-wch");
                        $answer->status = "1";
                        $answer->save();
                        break;
                    case "mch":
                        $i=1;
                        while (!empty($request->get("ans-".$i."-mch")))
                        {
                            $this->validate($request, [
                                "ans-".$i."-mch" => ['string','required'],
                                "ans-right-mch-".$i=> ['string'],
                            ]);
                            $answer = new Answers();
                            $answer->id_quest = $quest->id;
                            $answer->text = $request->get("ans-".$i."-mch");
                            if( !empty($request->get("ans-right-mch-".$i)))
                                $answer->status = "1";
                            else
                                $answer->status = "0";
                            $answer->save();
                            $i++;
                        }
                        break;
                    case "doc":
                        $answer = new Answers();
                        $this->validate($request, [
                            'ans-doc' => ['string','required'],
                            'doc-name' => ['string','required'],
                        ]);
                        $answer->id_quest = $quest->id;
                        $answer->text = $request->get("ans-doc");
                        $answer->status = "1";
                        $answer->save();

                        $docker = DockerContainers::firstOrCreate(["name"=>$request->get('doc-name')]);
                        $docker->id_quest = $quest->id;
                        $docker->name = $request->get("doc-name");
                        $docker->save();
                        break;
                    case "ch":
                        $i=1;
                        while (!empty($request->get("ans-".$i."-ch")))
                        {
                            $this->validate($request, [
                                "ans-".$i."-ch" => ['string','required'],
                                "ans-right-ch" => ['string','required'],
                            ]);
                            $answer = new Answers();
                            $answer->id_quest = $quest->id;
                            $answer->text = $request->get("ans-".$i."-ch");
                            if( !empty($request->get("ans-right-ch")) && $request->get("ans-right-ch")==$i)
                                $answer->status = "1";
                            else
                                $answer->status = "0";
                            $answer->save();
                            $i++;
                        }
                        break;
                    default:
                        return false;
                }


                return true;


            }) === true
        )
        {
            return Response::json([
                "message" => "Вопрос " . htmlspecialchars(trim($request->title)) . " успешно изменен"
            ],
                200,
                ['Content-type' => 'application/json; charset=utf-8'],
                JSON_UNESCAPED_UNICODE);
        }
        else
        {
            return Response::json([
                "message" => "Что-то пошло не так, вопрос не изменен."
            ],
                200,
                ['Content-type' => 'application/json; charset=utf-8'],
                JSON_UNESCAPED_UNICODE);
        }
    }


    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function deleteQuest(int $id)
    {
        Quests::findOrFail($id)->delete();
        return Response::json([
            "message" => "Вопрос успешно удален"
        ],
            200,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);
    }


    /******************************************** CATEGORIES ********************************************************/

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function categoriesList()
    {
        $categories = Categories::with("quests")->with("tests")->get();

        return Response::json(
            $categories
        ,
            200,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);
    }

    public function categoryDetail(int $id)
    {
        $category = Categories::with("quests")->findOrFail($id);
        return Response::json(
            $category
            ,
            200,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addCategory(Request $request)
    {
        $this->validate($request, [
            'name' => ['string', 'max:255','required'],
            'slug' => ['string', 'max:255','required','regex:|^[a-zA-Z]+$|', 'unique:categories'],
        ]);

        $category = new Categories();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->save();

        return Response::json([
            "message" => "Категория успешно добавлена"
        ],
            200,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param Request $request
     * @param $cat_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCategory(Request $request,$cat_id)
    {
        $category = Categories::findOrFail($request->cat_id);
        $this->validate($request, [
            'cat_id'=>['int','required'],
            'name' => ['string', 'max:255','required'],
            'slug' => ['string', 'max:255','required','regex:|^[a-zA-Z]+$|', 'unique:categories,id,'.$cat_id],
        ]);

        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->save();

        return Response::json([
            "message" => "Категория ".$category->name." успешно изменена"
        ],
            200,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param int $id_test
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function deleteCategory(int $id_cat)
    {
        if (!is_numeric($id_cat)) return false;

        Categories::where("id",$id_cat)->get()->first()->delete();

        return Response::json([
            "message" => "Категория успешно удалена"
        ],
            200,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);
    }

    /******************************************** FILES ********************************************************/

    public function deleteFile(int $id)
    {
        if (!is_numeric($id)) return false;

        $dbFile = Files::where("id",$id)->get()->first();
        $fileSystem = new Filesystem();
        $fileSystem->delete(public_path($dbFile->path));
        $dbFile->delete();


        return Response::json([
            "message" => "Вопрос успешно удален"
        ],
            200,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);
    }
}
