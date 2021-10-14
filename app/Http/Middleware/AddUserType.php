<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class AddUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if ($user) {
            if ($user->tokenCan('user:admin')) {
                $user->type = 'admin';
            } elseif ($user->tokenCan('user:teacher')) {
                $user->type = 'teacher';
            } elseif ($user->tokenCan('user:student')) {
                $user->type = 'student';
            }

            $request->setUserResolver(fn () =>  $user);
        }

        return $next($request);
    }
}
