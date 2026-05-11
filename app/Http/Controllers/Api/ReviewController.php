<?php

namespace App\Http\Controllers\Api;

use App\Criteria\LimitOffsetCriteria;
use App\Reviews\AiPerfomReview;
use App\Http\Controllers\Api\Controller;
use App\Models\Review;
use App\Repositories\Interfaces\ReviewRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ReviewController extends Controller
{

    /** @var ReviewRepository */
    private ReviewRepository $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository )
    {
        $this->reviewRepository = $reviewRepository;
        parent::__construct();
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $this->validate($request, Review::$rules   );
            $input = $request->all();
            $event = $this->reviewRepository->create($input);

        } catch (ValidationException $e) {
            return $this->sendError(array_values($e->errors()), 422);
        } catch (Exception $e) {
            Log::error("Error storing event: " . $e->getMessage());

            return $this->sendError($e->getMessage(), 500);
        }
        return $this->sendResponse($event, __('lang.saved_successfully', ['operator' => __('lang.resume')]));

    }
}
