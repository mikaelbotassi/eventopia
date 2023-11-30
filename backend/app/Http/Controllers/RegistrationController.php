<?php

namespace App\Http\Controllers;

use App\DTO\Registration\CreateRegistrationDTO;
use App\DTO\Registration\RegistrationDTO;
use App\DTO\Registration\UpdateRegistrationDTO;
use App\Services\RegistrationService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function __construct(
        private RegistrationService $registrationService
    ){
        $this->registrationService = new RegistrationService();

    }

    public function getById($id):JsonResponse
    {
        $obj = $this->registrationService->findById($id);
        return response()->json([
            'data' => $obj
        ])->setStatusCode(200);
    }

    /**
     * @throws Exception
     */
    public function getQrCode($event_id):JsonResponse
    {
        $obj = $this->registrationService->getQrCodeByEvent($event_id);
        return response()->json([
            'data' => $obj
        ])->setStatusCode(200);
    }

    /**
     * @throws Exception
     */
    public function confirmPresence($qrCode):JsonResponse
    {
        if($this->registrationService->confirmPresence($qrCode)){
            return response()->json([
                'status' => 'success',
                'message' => 'Presença confirmada',
            ])->setStatusCode(200);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Não conseguimos confirmar sua presença, tente novamente mais tarde.'
        ])->setStatusCode(406);
    }

    public function getAll():JsonResponse
    {
        $objs = $this->registrationService->getAll(new RegistrationDTO());
        return response()->json([
            'qtt' => $objs->count(),
            'data' => $objs
        ])->setStatusCode(200);
    }

    /**
     * @throws Exception
     */
    public function create(Request $request):JsonResponse
    {
        if($this->registrationService->create(CreateRegistrationDTO::makeFromRequest($request)))
            return response()->json(['message' => 'Inscrição confirmada com sucesso!'])->setStatusCode(200);
        return response()->json(['message' => 'Não foi possível confirmar sua inscrição neste momento,
        tente novamente mais tarde'])->setStatusCode(400);
    }

    public function update(Request $request, $id):JsonResponse
    {
        if($this->registrationService->update(UpdateRegistrationDTO::makeFromRequest($request), $id))
            return response()->json(['message' => 'Inscrição atualizada com sucesso!'])->setStatusCode(200);
        return response()->json(['message' => 'Não foi possível salvar seus dados'])->setStatusCode(400);
    }

    /**
     * @throws Exception
     */
    public function delete($id):JsonResponse
    {
        if($this->registrationService->delete($id))
            return response()->json(['message' => 'Inscrição cancelada com sucesso!'])->setStatusCode(200);
        return response()->json(['message' => 'Não foi possível cancelar sua inscrição neste momento'])->setStatusCode(400);
    }

    public function getAllWithFilter(Request $request):JsonResponse
    {
        $objs = $this->registrationService->getAllWithFilter($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'Dados obtidos com sucesso',
            'qtt' => $objs->count(),
            'data' => $objs
        ])->setStatusCode(200);
    }

    public function getAllByAuthId():JsonResponse
    {
        $objs = $this->registrationService->getAllByAuthId();
        return response()->json([
            'status' => 'success',
            'message' => 'Dados obtidos com sucesso',
            'qtt' => $objs->count(),
            'data' => $objs
        ])->setStatusCode(200);
    }

}
