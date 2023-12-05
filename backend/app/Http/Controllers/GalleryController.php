<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadImageRequest;
use App\Services\GalleryService;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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

    /**
     * @throws Exception
     */
    public function getImage($imageUrl): BinaryFileResponse
    {
        $imagePath = storage_path("app/public/{$imageUrl}");
        if (Storage::exists("public/{$imageUrl}")) {
            return response()->file($imagePath);
        } else throw new Exception("Imagem não encontrada", 404);
    }

    /**
     * @throws Exception
     */
    public function delete($id):JsonResponse
    {
        if($this->galleryService->delete($id))
            return response()->json(['message' => 'Imagem deletada com sucesso'])->setStatusCode(200);
        return response()->json(['message' => 'Não foi possível deletar a imagem no momento, tente novamente mais tarde'])->setStatusCode(400);
    }


}
