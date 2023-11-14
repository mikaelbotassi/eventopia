<?php

namespace App\Http\Controllers;

use App\DTO\Certificate\CertificateDTO;
use App\DTO\Certificate\CreateCertificateDTO;
use App\DTO\Certificate\UpdateCertificateDTO;
use App\Services\CertificateService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function __construct(
        private CertificateService $certificateService
    ){
        $this->certificateService = new CertificateService();

    }

    public function getById($id):JsonResponse
    {
        try {
            $obj = $this->certificateService->findById($id);
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
            $objs = $this->certificateService->getAll(new CertificateDTO());
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
            if($this->certificateService->create(CreateCertificateDTO::makeFromRequest($request)))
                return response()->json(['message' => 'Record created successfully'])->setStatusCode(200);
            return response()->json(['message' => 'Unable to save Record data'])->setStatusCode(400);
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id):JsonResponse
    {
        try {
            if($this->certificateService->update(UpdateCertificateDTO::makeFromRequest($request), $id))
                return response()->json(['message' => 'Record updated successfully'])->setStatusCode(200);
            return response()->json(['message' => 'Unable to save Record data'])->setStatusCode(400);
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function delete($id):JsonResponse
    {
        try {
            if($this->certificateService->delete($id))
                return response()->json(['message' => 'Record deleted successfully'])->setStatusCode(200);
            return response()->json(['message' => 'Unable to save Record data'])->setStatusCode(400);
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

}
