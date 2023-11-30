<?php

namespace App\Http\Controllers;

use App\DTO\Feedback\CreateFeedbackDTO;
use App\DTO\Feedback\FeedbackDTO;
use App\DTO\Feedback\UpdateFeedbackDTO;
use App\Services\CategoryService;
use App\Services\FeedbackService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class FeedbackController extends Controller
{
    public function __construct(
        private FeedbackService $feedbackService
    ){
        $this->feedbackService = new FeedbackService();

    }

    public function getById($id):JsonResponse
    {
        $obj = $this->feedbackService->findById($id);
        return response()->json([
            'data' => $obj
        ])->setStatusCode(200);
    }

    public function getAll():JsonResponse
    {
        $objs = $this->feedbackService->getAll(new FeedbackDTO());
        return response()->json([
            'qtt' => $objs->count(),
            'data' => $objs
        ])->setStatusCode(200);
    }

    public function getAllWithFilter(Request $request):JsonResponse
    {
        $objs = $this->feedbackService->getAllWithFilter($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'Dados obtidos com sucesso',
            'qtt' => $objs->count(),
            'data' => $objs
        ])->setStatusCode(200);
    }

    public function create(Request $request):JsonResponse
    {
        if($this->feedbackService->create(CreateFeedbackDTO::makeFromRequest($request)))
            return response()->json(['message' => 'Feedback created successfully'])->setStatusCode(200);
        return response()->json(['message' => 'Unable to save Feedback data'])->setStatusCode(400);
    }

    public function update(Request $request, $id):JsonResponse
    {
        if($this->feedbackService->update(UpdateFeedbackDTO::makeFromRequest($request), $id))
            return response()->json(['message' => 'Feedback updated successfully'])->setStatusCode(200);
        return response()->json(['message' => 'Unable to save Feedback data'])->setStatusCode(400);
    }

    public function delete($id):JsonResponse
    {
        if($this->feedbackService->delete($id))
            return response()->json(['message' => 'Feedback deleted successfully'])->setStatusCode(200);
        return response()->json(['message' => 'Unable to save Feedback data'])->setStatusCode(400);
    }

}
