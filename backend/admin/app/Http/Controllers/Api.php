<?php

namespace App\Http\Controllers;

use App\Users;
use App\UsersStatus;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
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
        if ($id == 1) return Response::json(["message" => "Администратора удалять нельзя"],
            200,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);
        Users::where("id", $id)->get()->first()->delete();
        return Response::json(["message" => "Пользователь успешно удален"],
            200,
            ['Content-type' => 'application/json; charset=utf-8'],
            JSON_UNESCAPED_UNICODE);
    }
}
