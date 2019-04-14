<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Admin extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
    Главная страница
     */
    public function indexPage()
    {
        if (!Auth::check())
        {
            return redirect('/login');
        }
        return view('index');
    }
}
