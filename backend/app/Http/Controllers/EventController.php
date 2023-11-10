<?php

namespace App\Http\Controllers;

use App\DTO\Event\CreateEventDTO;
use App\DTO\Event\EventDTO;
use App\DTO\Event\UpdateEventDTO;
use App\Services\EventService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct(
        private EventService $eventService
    ){
        $this->eventService = new EventService();

    }

    public function getById($id):JsonResponse
    {
        try {
            $obj = $this->eventService->findById($id);
            return response()->json([
                'data' => $obj
            ])->setStatusCode(200);
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function getAll():JsonResponse
    {
        try {
            $objs = $this->eventService->getAll(new EventDTO());
            return response()->json([
                'qtt' => $objs->count(),
                'data' => $objs
            ])->setStatusCode(200);
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function create(Request $request):JsonResponse
    {
        try {
            if($this->eventService->create(CreateEventDTO::makeFromRequest($request)))
                return response()->json(['message' => 'Event created successfully'])->setStatusCode(200);
            return response()->json(['message' => 'Unable to save Event data'])->setStatusCode(400);
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id):JsonResponse
    {
        try {
            if($this->eventService->update(UpdateEventDTO::makeFromRequest($request), $id))
                return response()->json(['message' => 'Event updated successfully'])->setStatusCode(200);
            return response()->json(['message' => 'Unable to save Event data'])->setStatusCode(400);
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function delete($id):JsonResponse
    {
        try {
            if($this->eventService->delete($id))
                return response()->json(['message' => 'Event deleted successfully'])->setStatusCode(200);
            return response()->json(['message' => 'Unable to save Event data'])->setStatusCode(400);
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

}
