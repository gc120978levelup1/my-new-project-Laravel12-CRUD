<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class FirstAdmin
{
    /**
     * Handle an incoming request.
     * Check if the user is an admin or a first user
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $users = User::limit(1)->get();
        if (($users->count() == 0)||(Auth::user() && (Auth::user()->role == "admin"))) {
            return $next($request); // user passwed the filter so it will be allowed to pass
        }else{
            return abort(401); // wrong way
        }
    }
}
