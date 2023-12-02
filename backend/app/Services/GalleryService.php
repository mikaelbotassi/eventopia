<?php

namespace App\Services;

use App\Http\Requests\UploadImageRequest;
use App\Models\Gallery;
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
}
