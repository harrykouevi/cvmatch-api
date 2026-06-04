<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\Controller as ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserProfileResource;
use App\Repositories\Interfaces\AnalyseRepository;
use App\Repositories\Interfaces\ResumeRepository;
use App\Repositories\Interfaces\UserRepository;
use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken;



class AuthController extends ApiController
{
    /** @var AnalyseRepository */
    private AnalyseRepository $analyseRepository;

    /** @var ResumeRepository */
    private ResumeRepository $resumeRepository;


    /** @var  UserRepository */
    private UserRepository $userRepository;

    public function __construct(
        UserRepository  $userRepo,
        AnalyseRepository $analyseRepo ,
        ResumeRepository $resumeRepo ,
    ) {
        parent::__construct();
        $this->userRepository = $userRepo;
        $this->analyseRepository = $analyseRepo;
        $this->resumeRepository = $resumeRepo;
    }

    public function show(Request $request): JsonResponse
    {
        Log::info([$request->user()])  ;

        $user = $request->user() ?? $request->attributes->get('current_user') ?? null ;
        $user = $user->loadProfileData();

        return $this->sendResponse( new UserProfileResource($user), __('lang.data_fetched_successfully', ['operator' => __('lang.resume')]));
    }

    public function acceptTerms(Request $request)
    {
        try {
            $user = Auth::user() ?? $request->attributes->get('current_user');
            if (!$user) {
                throw new Exception("User not authenticated");
            }

            $user->update([
                'terms_accepted' => true,
                'terms_accepted_at' => now(),
            ]);

            // $user = $user->loadProfileData();

        } catch (Exception $e) {
            Log::error("Error updated user: " . $e->getMessage());
            return $this->sendError($e->getMessage(), 500);
        }


        return $this->sendResponse( [], __('lang.saved_successfully', ['operator' => __('lang.auth')]));

    }

    public function redirectToGoogle(Request $request)
    {
        // return Socialite::driver('google')->stateless()->redirect();


        $guestToken = request('guest_token');
        $guestUser = Null ;
        if ($guestToken) {
            $guestUser = $this->userRepository->findWhere([
                'guest_token' => $guestToken,
                'is_guest' => true,
            ])->first();
        }

        $existingUser = $this->userRepository->findByField('email', 'harry.kouevi@gmail.com')->first();

        if ($existingUser) {
            if ($guestUser) {

                Log::error(['guestUser is doing fusion']) ;

                $analyses = $this->analyseRepository->findByField('user_id', $guestUser->id);
                Log::error(['analyse count',$analyses->count()])  ;
                foreach ($analyses as $analyse) {
                    $analyse->update([
                        'user_id' => $existingUser->id
                    ]);
                }

                $resumes = $this->resumeRepository->findByField('user_id', $guestUser->id) ;
                Log::error(['$resumes count',$resumes->count()])  ;

                foreach ($resumes as $analyse) {
                    $analyse->update([
                        'user_id' => $existingUser->id
                    ]);
                }

                $this->userRepository->update([
                    'current_analyse_done' =>  $guestUser->current_analyse_done,
                ], $guestUser->id);
                // supprimer guest
                $guestUser->delete();
            }

        }else{

             /**
             * CAS 2 :
             * convertir le guest en vrai compte
             */
            if ($guestUser) {

                $this->userRepository->update([
                    'name' => 'harry.kouevi',
                    'email' => 'harry.kouevi@gmail.com',
                    'password' => bcrypt(str()->random(16)),
                    'is_guest' => false,
                    'guest_token' => null,
                ], $guestUser->id);

                $existingUser = $guestUser;

            } else {

                 /**
                 * CAS 3 :
                 * aucun guest
                 */
                $existingUser = $this->userRepository->create([
                    'name' => 'harry.kouevi',
                    'email' => 'harry.kouevi@gmail.com',
                    'password' => bcrypt(str()->random(16)),
                    'is_guest' => false,
                    'guest_token' => null,
                    'current_analyse_done' => null,
                ]);
            }
        }


        $token = $existingUser->createToken('api-token')->plainTextToken;
        $token = urlencode($token) ;
        return redirect("http://localhost:5173/auth/callback?token={$token}");
    }

    public function handleGoogleCallback(Request $request)
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $guestToken = request('guest_token');
        $guestUser = Null ;
        if ($guestToken) {
            $guestUser = $this->userRepository->findWhere([
                'guest_token' => $guestToken,
                'is_guest' => true,
            ])->first();
        }

        $existingUser = $this->userRepository->findByField('email', $googleUser->getEmail())->first();

        if ($existingUser) {
            if ($guestUser) {

                Log::error(['guestUser is doing fusion']) ;

                $analyses = $this->analyseRepository->findByField('user_id', $guestUser->id);
                Log::error(['analyse count',$analyses->count()])  ;
                foreach ($analyses as $analyse) {
                    $analyse->update([
                        'user_id' => $existingUser->id
                    ]);
                }

                $resumes = $this->resumeRepository->findByField('user_id', $guestUser->id) ;
                Log::error(['$resumes count',$resumes->count()])  ;

                foreach ($resumes as $analyse) {
                    $analyse->update([
                        'user_id' => $existingUser->id
                    ]);
                }

                $this->userRepository->update([
                    'current_analyse_done' =>  $guestUser->current_analyse_done,
                ], $guestUser->id);

                // supprimer guest
                $guestUser->delete();
            }

        }else{

             /**
             * CAS 2 :
             * convertir le guest en vrai compte
             */
            if ($guestUser) {

                $this->userRepository->update([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(str()->random(16)),
                    'is_guest' => false,
                    'guest_token' => null,
                ], $guestUser->id);

                $existingUser = $guestUser;

            } else {

                 /**
                 * CAS 3 :
                 * aucun guest
                 */
                $existingUser = $this->userRepository->create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(str()->random(16)),
                    'is_guest' => false,
                    'guest_token' => null,
                    'current_analyse_done' => null,
                ]);
            }
        }

        $token = $existingUser->createToken('api-token')->plainTextToken;
        $token = urlencode($token) ;
        return redirect("https://cvmatchai.us/auth/callback?token={$token}");
    }


    public function logout(Request $request)
    {

        $bearer = $request->bearerToken();
        if ($bearer) {
            $token = PersonalAccessToken::findToken($bearer);
            if ($token) {
                $token->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Logged out successfully'
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Unauthenticated'
        ], 401);
    }
}
