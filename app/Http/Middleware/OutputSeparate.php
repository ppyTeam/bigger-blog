<?php

namespace App\Http\Middleware;

use Closure;

class OutputSeparate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $from)
    {

        // Perform action

        switch ($from) {
            case 'web':
                $request->headers->set('return_type', 'web');
                break;
            case 'api':
                $request->headers->set('return_type', 'api');
                $request->route()->uri();
                $web_uri = preg_replace("/api\/(.*)/isU", '', $request->route()->uri());
                $request->route()->setUri($web_uri);
                break;
            default:
                break;
        }
        return $next($request);

    }
}
