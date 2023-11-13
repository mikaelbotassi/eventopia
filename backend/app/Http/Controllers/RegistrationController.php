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
        try {
            $obj = $this->registrationService->findById($id);
            return response()->json([
                'data' => $obj
            ])->setStatusCode(200);
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function getQrCode($event_id):JsonResponse
    {
        try {
            $obj = $this->registrationService->getQrCodeByEvent($event_id);
            return response()->json([
                'data' => $obj
            ])->setStatusCode(200);
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function confirmPresence($qrCode):JsonResponse
    {
        try {
            if($this->registrationService->confirmPresence($qrCode)){
                return response()->json([
                    'data' => 'Presence confirmed successfully'
                ])->setStatusCode(200);
            }
            return response()->json([
                'data' => 'We were unable to confirm your presence, please try again later'
            ])->setStatusCode(406);
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function getAll():JsonResponse
    {
        try {
            $objs = $this->registrationService->getAll(new RegistrationDTO());
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
            if($this->registrationService->create(CreateRegistrationDTO::makeFromRequest($request)))
                return response()->json(['message' => 'Record created successfully'])->setStatusCode(200);
            return response()->json(['message' => 'Unable to save Record data'])->setStatusCode(400);
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id):JsonResponse
    {
        try {
            if($this->registrationService->update(UpdateRegistrationDTO::makeFromRequest($request), $id))
                return response()->json(['message' => 'Record updated successfully'])->setStatusCode(200);
            return response()->json(['message' => 'Unable to save Record data'])->setStatusCode(400);
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function delete($id):JsonResponse
    {
        try {
            if($this->registrationService->delete($id))
                return response()->json(['message' => 'Record deleted successfully'])->setStatusCode(200);
            return response()->json(['message' => 'Unable to save Record data'])->setStatusCode(400);
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

}
