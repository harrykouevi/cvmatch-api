<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller as ApiController;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UserRepository;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\JsonResponse;


class AuthController extends ApiController
{

    /** @var  UserRepository */
    private UserRepository $userRepository;

    public function __construct(UserRepository  $userRepo)
    {
        parent::__construct();
        $this->userRepository = $userRepo;
    }

    public function show(Request $request): JsonResponse
    {
        return $this->sendResponse([$request->user()], __('lang.saved_successfully', ['operator' => __('lang.resume')]));
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // $existingUser = User::where('email', $user->getEmail())->first();
        $existingUser = $this->userRepository->findByField('email', $googleUser->getEmail())->first();

        if (!$existingUser) {
            // $existingUser = User::create([
            //     'name' => $user->getName(),
            //     'email' => $user->getEmail(),
            //     'password' => bcrypt(str()->random(16)),
            // ]);
            $existingUser = $this->userRepository->create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(str()->random(16)),
                'is_guest' => false,
            ]);
        }


        $token = $existingUser->createToken('api-token')->plainTextToken;

        // return redirect(
        //     "http://localhost:3000/auth/callback?token={$token}"
        // );
        $token = urlencode($token) ;

        return redirect("https://cvmatchai.us/auth/callback?token={$token}");
    }
}
