<?php

namespace App\Http\Middleware;

use App\Services\UserService;
use App\Traits\ApiResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasSetPinMiddleware
{
    use ApiResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $userService = new UserService();

        if(!$userService->hasSetPin($user)){
            return $this->sendError('Pin not set!', Response::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
