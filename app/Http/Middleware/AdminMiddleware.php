<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use App\Traits\ResponseTrait;

class AdminMiddleware {

    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {

        if( !auth( "sanctum" )->check() || !auth()->user()->isAdmin() ) {

            return $this->sendError( "Azonosítási hiba", [ "Admin jog szükséges", 403 ]);
        }
        
        return $next( $request );
    }
}
