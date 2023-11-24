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
        $obj = $this->eventService->findById($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Dados obtidos com sucesso',
            'data' => $obj
        ])->setStatusCode(200);
    }

    public function getAll():JsonResponse
    {
        $objs = $this->eventService->getAll(new EventDTO());
        return response()->json([
            'status' => 'success',
            'message' => 'Dados obtidos com sucesso',
            'qtt' => $objs->count(),
            'data' => $objs
        ])->setStatusCode(200);
    }

    public function create(Request $request):JsonResponse
    {
        if($this->eventService->create(CreateEventDTO::makeFromRequest($request)))
            return response()->json(['message' => 'Evento criado com sucesso'])->setStatusCode(200);

        return response()->json(['message' => 'Não foi possível salvar os dados'])->setStatusCode(400);
    }

    public function update(Request $request, $id):JsonResponse
    {
        if($this->eventService->update(UpdateEventDTO::makeFromRequest($request), $id))
            return response()->json(['message' => 'Evento alterado com sucesso'])->setStatusCode(200);
        return response()->json(['message' => 'Não foi possível alterar o evento no momento, tente novamente mais tarde'])->setStatusCode(400);
    }

    public function delete($id):JsonResponse
    {
        if($this->eventService->delete($id))
            return response()->json(['message' => 'Evento deletado com sucesso'])->setStatusCode(200);
        return response()->json(['message' => 'Não foi possível deletar o evento no momento, tente novamente mais tarde'])->setStatusCode(400);
    }

}
