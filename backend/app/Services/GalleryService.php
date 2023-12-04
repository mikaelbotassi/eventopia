<?php

namespace App\Services;

use App\Http\Requests\UploadImageRequest;
use App\Models\Gallery;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;

class GalleryService
{
    /**
     * @throws FileNotFoundException
     */
    public function uploadImage(UploadImageRequest $request){
        $validatedData = $request->validated();
        $file = $validatedData['image'];
        $filename = $file->getClientOriginalName();

        $hash = hash('sha256', time());

        $path = 'uploads/'.$validatedData['model'].'/' . $hash;

        if($file->storeAs($path, $filename, 'public')) {
            $input['filename'] = $filename;
            $input['mime'] = $file->getClientMimeType();
            $input['path'] = $path;
            $input['size'] = $file->getSize();
            $gallery = Gallery::create($input);

            return $gallery->id;
        }
        return false;
    }

    /**
     * @throws Exception
     */
    public function delete(int $id):bool{
        $obj = Gallery::findByOrFail($id);
        $imagePath = $obj->path.'/'.$obj->filename;
        if(!$obj->delete()) return false;
        if (Storage::exists("public/{$imagePath}"))
            return Storage::delete("public/$imagePath");
        throw new Exception("Não foi possível encontrar a imagem", 404);
    }
}
