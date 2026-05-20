<?php

namespace App\Http\Controllers\Api;

use App\Criteria\Addresses\CreditsOfUserCriteria;
use App\Criteria\LimitOffsetCriteria;
use App\Http\Controllers\Api\Controller;
use App\Repositories\Interfaces\CreditRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

class CreditController extends Controller
{
     /** @var CreditRepository */
    private CreditRepository $creditRepository;



    public function __construct(
        CreditRepository $creditRepository,
    )
    {
        $this->creditRepository = $creditRepository;
        parent::__construct();
    }


    public function myCredits(Request $request): JsonResponse
    {
        $user = $request->user();
        $this->creditRepository->resetCriteria();
        try {
            $this->creditRepository->pushCriteria(new RequestCriteria($request));
            $this->creditRepository->pushCriteria(new LimitOffsetCriteria($request));
            $credits = $this->creditRepository->getByCriteria(new CreditsOfUserCriteria($user->id));

        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
        $data = $credits->map(function ($credit) {
            return [
                'user_id' => $credit->user_id,
                'remaining_credits' => $credit->remaining_credits,
            ];
        });

        return $this->sendResponse( $data ,'credit get successfully'  );
    }
}
