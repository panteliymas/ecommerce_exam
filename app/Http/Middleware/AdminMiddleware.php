<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $viewer = Auth::user();
        if (!$viewer || !$viewer->isAdmin()) {
            return $request->wantsJSON() 
                ? redirect()->route('login')->with('error', 'You are not authorized to access this page')
                : response()->json(['status' => false, 'errors' => ['You don\'t have permissions to view/edit this content']], 403);
        }

        return $next($request);
    }
}
