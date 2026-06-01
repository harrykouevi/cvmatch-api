<?php

namespace App\Http\Controllers\Api;

use App\Criteria\LimitOffsetCriteria;
use App\Http\Controllers\Api\Controller;
use App\Repositories\Interfaces\CreditPlanRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;


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
        $products = $this->creditPlanRepository->scopeQuery(function ($query) {
            return $query->where('is_active', true)
                        ->where('credits', '>', 0)
                        ->orderBy('price', 'asc'); ;
        })->get();


        return $this->sendResponse( $products->toArray(),'plan get successfully'  );

    }

    public function show(int $id, Request $request): JsonResponse
    {

        try {
            $this->creditPlanRepository->pushCriteria(new RequestCriteria($request));
            $this->creditPlanRepository->pushCriteria(new LimitOffsetCriteria($request));
            $product = $this->creditPlanRepository->findWhere([
                'id' => $id
            ])
            ->first();
            if (empty($product)) {
                return $this->sendError('Analyse not found');
            }

        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }



        return $this->sendResponse(
            $product,
            'product retrieved successfully'
        );
    }

}
