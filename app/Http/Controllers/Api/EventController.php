<?php

namespace App\Http\Controllers\Api;

use App\Criteria\LimitOffsetCriteria;
use App\Events\AiPerfomEvent;
use App\Http\Controllers\Api\Controller;
use App\Models\Event;
use App\Repositories\Interfaces\EventRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class EventController extends Controller
{
    /** @var EventRepository */
    private EventRepository $eventRepository;

    public function __construct(EventRepository $eventRepository )
    {
        $this->eventRepository = $eventRepository;
        parent::__construct();
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $this->validate($request, Event::$rules   );
            $input = $request->all();
            $event = $this->eventRepository->create($input);

        } catch (ValidationException $e) {
            return $this->sendError(array_values($e->errors()), 422);
        } catch (Exception $e) {
            Log::error("Error storing event: " . $e->getMessage());

            return $this->sendError($e->getMessage(), 500);
        }
        return $this->sendResponse($event, __('lang.saved_successfully', ['operator' => __('lang.resume')]));

    }
}
