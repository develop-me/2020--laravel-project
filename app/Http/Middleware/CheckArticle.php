<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckArticle
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
        if ($request->route("article")->id !== $request->route("comment")->article_id) {
            abort(404);
        }

        return $next($request);
    }
}
