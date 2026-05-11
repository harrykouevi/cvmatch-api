<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller as ApiController;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UserRepository;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\JsonResponse;


class OAuthController extends ApiController
{

    /** @var  UserRepository */
    private UserRepository $userRepository;

    public function __construct(UserRepository  $userRepo)
    {
        parent::__construct();
        $this->userRepository = $userRepo;
    }



}
