<?php

namespace App\Http\Controllers;

use App\DTO\User\CreateUserDTO;
use App\DTO\User\UserDTO;
use App\Models\User;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ){
        $this->userService = new UserService();
    }

    public function update(Request $request):JsonResponse
    {
        try {
            if($this->userService->update(UserDTO::makeFromRequest($request)))
                return response()->json(['message' => 'User updated successfully'])->setStatusCode(200);
            return response()->json(['message' => 'Unable to save user data'])->setStatusCode(200);
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function create(Request $request):JsonResponse
    {
        try {
            if($this->userService->create(CreateUserDTO::makeFromRequest($request)))
                return response()->json(['message' => 'User created successfully'])->setStatusCode(200);
            return response()->json(['message' => 'Unable to save user data'])->setStatusCode(200);
        }catch (Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }

}
