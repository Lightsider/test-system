<?php

namespace App\Http\Middleware;

use App\TempTesting;
use Closure;
use Illuminate\Support\Facades\Auth;

class Testing
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $temp_testing = TempTesting::where("id_user", $user->id)->get()->first();
        if (!empty($temp_testing) &&  $request->route()->getAction()["as"]!=="testing") return redirect("/testing");

        return $next($request);
    }
}
