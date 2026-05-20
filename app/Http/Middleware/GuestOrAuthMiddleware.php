<?php

namespace App\Http\Middleware;

use App\Repositories\Interfaces\UserRepository;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class GuestOrAuthMiddleware
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         // Auth user via Sanctum token
        $bearer = $request->bearerToken();

        if ($bearer) {

            $token = PersonalAccessToken::findToken($bearer);
            if ($token) {
                $user = $token->tokenable;

                $request->attributes->set(
                    'current_user',
                    $token->tokenable
                );
                if($user->is_guest == false ) Auth::setUser($user);

                return $next($request);
            }
        }

        $guestToken = $request->header('X-Guest-Token');

        if (!$guestToken) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        $user = $this->userRepository
            ->findWhere([
                'guest_token' => $guestToken,
                'is_guest' => true
            ])
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid guest session'
            ], 401);
        }

        $request->attributes->set('current_user', $user);

        return $next($request);
    }

}
