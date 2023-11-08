<?php

namespace App\Http\Controllers;

use App\DTO\Category\CategoryDTO;
use App\Services\CategoryService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryService $categoryService
    ){
        $this->categoryService = new CategoryService();

    }

    public function getAll():JsonResponse
    {
        try {
            $categories = $this->categoryService->getAll();
            return response()->json(['data' => $categories])->setStatusCode(200);
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function create(Request $request):JsonResponse
    {
        try {
            if($this->categoryService->create(CategoryDTO::makeFromRequest($request)))
                return response()->json(['message' => 'Category created successfully'])->setStatusCode(200);
            return response()->json(['message' => 'Unable to save category data'])->setStatusCode(400);
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
