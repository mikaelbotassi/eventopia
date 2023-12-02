<?php

namespace App\Http\Controllers;

use App\DTO\Certificate\CertificateDTO;
use App\DTO\Certificate\CreateCertificateDTO;
use App\DTO\Certificate\UpdateCertificateDTO;
use App\Http\Requests\UploadImageRequest;
use App\Services\CertificateService;
use App\Services\GalleryService;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function __construct(
        private GalleryService $galleryService
    ){
        $this->galleryService = new GalleryService();

    }

    /**
     * @throws FileNotFoundException
     */
    public function uploadImage(UploadImageRequest $request):JsonResponse
    {
        if($id = $this->galleryService->uploadImage($request))
            return response()->json([
                'id' => $id,
                'message' => 'Imagem salva com sucesso'
            ])->setStatusCode(200);
        return response()->json([
            'status' => 'error',
            'message' => 'Unable to save Record data'
        ])->setStatusCode(400);
    }

}
