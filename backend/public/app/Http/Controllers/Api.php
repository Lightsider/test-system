<?php

namespace App\Http\Controllers;

use App\Answers;
use App\Categories;
use App\Files;
use App\Quests;
use App\QuestToCategory;
use App\Settings;
use App\TempTesting;
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
use Mockery\Exception;

class Api extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /******************************************** TEST ********************************************************/


    /**
     * @param $id
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function checkAnswer(Request $request)
    {
        $this->validate($request, [
            'test_id' => ['int', 'required'],
            'user_id' => ['int', 'required'],
            'token' => ['string', 'required'],
        ]);
        $temp_testing = TempTesting::where("id_test", $request->test_id)->where("id_user", $request->user_id)->get()->first();
        if (!$temp_testing->isTestingProcessing() || !Hash::check($temp_testing->id, $request->token)) {
            return Response::json(
                [
                    "status" => "error",
                    "message" => "Тестирование не найдено"
                ],
                404,
                ['Content-type' => 'application/json; charset=utf-8'],
                JSON_UNESCAPED_UNICODE);
        }

        $response = [];
        $quest = $temp_testing->quest;
        $quest_arr = $temp_testing->quest_arr;

        if ($quest_arr->{$quest->id}->answered == 0) {


            $showResult = false;
            if ($temp_testing->test->type === "learn") {
                $showResult = true;
            }

            try {
                switch ($quest->type) {
                    case "wch":
                        $this->validate($request, [
                            'answer' => ['string', 'required'],
                        ]);
                        $answer = $quest->answers[0];
                        if (trim($answer->text) === trim($request->answer))
                            $quest_arr->{$quest->id}->score = $quest->score;
                        $quest_arr->{$quest->id}->answered = 1;
                        break;
                    case "mch":
                        $this->validate($request, [
                            'answer' => ['array', 'required'],
                        ]);
                        $answers = $quest->answers;
                        $user_answers = $request->answer;
                        $user_answers = array_map('trim', $user_answers);
                        $right_answers_count = $right_user_answers_count = 0;
                        foreach ($answers as $answer) {
                            if ($answer->status == 1) {
                                $right_answers_count++;
                                if (in_array(trim($answer->id), $user_answers))
                                    $right_user_answers_count++;
                            }
                        }
                        $quest_arr->{$quest->id}->answered = 1;
                        $quest_arr->{$quest->id}->score = ($quest->score * ($right_user_answers_count / $right_answers_count));
                        break;
                    case "ch":
                        $this->validate($request, [
                            'answer' => ['string', 'required'],
                        ]);
                        $answers = $quest->answers;
                        $user_answer = $request->answer;
                        $user_answer = trim($user_answer);
                        foreach ($answers as $answer) {
                            if ($answer->status == 1) {
                                if (trim($answer->id) == $user_answer)
                                    $quest_arr->{$quest->id}->score = $quest->score;
                            }
                        }
                        $quest_arr->{$quest->id}->answered = 1;
                        break;
                    case "doc":
                        $this->validate($request, [
                            'answer' => ['string', 'required'],
                        ]);
                        $answer = $quest->answers[0];
                        if (trim($answer->text) === trim($request->answer))
                            $quest_arr->{$quest->id}->score = $quest->score;
                        $quest_arr->{$quest->id}->answered = 1;
                        break;
                    default:
                        $response["status"] = "error";
                        $response["message"] = "server error: invalid quest type";
                }

                $temp_testing->quest_arr = json_encode((array)$quest_arr);
                $temp_testing->save();
                if (!$showResult) {
                    $response['status'] = "ok";
                } else {
                    if ($quest->score == $quest_arr->{$quest->id}->score)
                        $response['status'] = "success";
                    else
                        $response['status'] = "fail";
                    $response["message"] = $quest->hint;
                }


                return Response::json($response,
                    200,
                    ['Content-type' => 'application/json; charset=utf-8'],
                    JSON_UNESCAPED_UNICODE);
            } catch (\Exception $e) {
                return Response::json(
                    [
                        "status" => "error",
                        "message" => "Ошибка при сохранении ответа: " . $e->getMessage() . " on line " . $e->getLine()
                    ],
                    500,
                    ['Content-type' => 'application/json; charset=utf-8'],
                    JSON_UNESCAPED_UNICODE);
            }
        } else {
            return Response::json(
                [
                    "status" => "error",
                    "message" => "Ответ уже засчитан"
                ],
                400,
                ['Content-type' => 'application/json; charset=utf-8'],
                JSON_UNESCAPED_UNICODE);
        }

    }
}
