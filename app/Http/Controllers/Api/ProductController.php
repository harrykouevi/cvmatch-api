<?php

namespace App\Http\Controllers\Api;

use App\Criteria\LimitOffsetCriteria;
use App\Http\Controllers\Api\Controller;
use App\Repositories\Interfaces\CreditPlanRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

class ProductController extends Controller
{

    /** @var CreditPlanRepository */
    private CreditPlanRepository $creditPlanRepository;



    public function __construct(
        CreditPlanRepository $creditPlanRepository,

    )
    {
        $this->creditPlanRepository = $creditPlanRepository;
        parent::__construct();
    }


    public function index(Request $request): JsonResponse
    {
        $this->creditPlanRepository->resetCriteria();
        try {
            $this->creditPlanRepository->pushCriteria(new RequestCriteria($request));
            $this->creditPlanRepository->pushCriteria(new LimitOffsetCriteria($request));
        } catch (Exception $e) {
            return $this->sendError($e->getMessage());
        }
        $products = $this->creditPlanRepository->findWhere([ 'is_active' => true]);

        return $this->sendResponse( $products->toArray(),'plan get successfully'  );

    }

}
