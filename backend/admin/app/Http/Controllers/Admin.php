<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Admin extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    /**
    index page
     */
    public function index()
    {
        if (!Auth::check())
        {
            return redirect('login');
        }
        return view('index');
    }
}
