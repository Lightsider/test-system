<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
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

        $status = $user->usersStatus()->get()->all()[0]->value;
        if($status!=="admin")
        {
            return redirect("//".config("params.public_site_url"));
        }

        return $next($request);
    }
}
