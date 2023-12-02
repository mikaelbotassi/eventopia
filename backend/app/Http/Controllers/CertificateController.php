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
        $obj = $this->certificateService->findById($id);
        return response()->json([
            'data' => $obj
        ])->setStatusCode(200);
    }

    public function getByCode($code):JsonResponse
    {
        $obj = $this->certificateService->getByCode($code);
        return response()->json([
            'data' => $obj
        ])->setStatusCode(200);
    }

    public function getAll():JsonResponse
    {
        $objs = $this->certificateService->getAll(new CertificateDTO());
        return response()->json([
            'qtt' => $objs->count(),
            'data' => $objs
        ])->setStatusCode(200);
    }

    public function getAllByAuthId():JsonResponse
    {
        $objs = $this->certificateService->getAllByAuthId();
        return response()->json([
            'qtt' => $objs->count(),
            'data' => $objs
        ])->setStatusCode(200);
    }

    public function create(Request $request):JsonResponse
    {
        if($this->certificateService->create(CreateCertificateDTO::makeFromRequest($request)))
            return response()->json(['message' => 'Record created successfully'])->setStatusCode(200);
        return response()->json(['message' => 'Unable to save Record data'])->setStatusCode(400);
    }

    public function update(Request $request, $id):JsonResponse
    {
        if($this->certificateService->update(UpdateCertificateDTO::makeFromRequest($request), $id))
            return response()->json(['message' => 'Record updated successfully'])->setStatusCode(200);
        return response()->json(['message' => 'Unable to save Record data'])->setStatusCode(400);
    }

    public function delete($id):JsonResponse
    {
        if($this->certificateService->delete($id))
            return response()->json(['message' => 'Record deleted successfully'])->setStatusCode(200);
        return response()->json(['message' => 'Unable to save Record data'])->setStatusCode(400);
    }

    public function getAllWithFilter(Request $request):JsonResponse
    {
        $objs = $this->certificateService->getAllWithFilter($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'Dados obtidos com sucesso',
            'qtt' => $objs->count(),
            'data' => $objs
        ])->setStatusCode(200);
    }

}
