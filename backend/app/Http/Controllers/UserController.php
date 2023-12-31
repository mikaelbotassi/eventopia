<?php

namespace App\Http\Controllers;

use App\DTO\User\CreateUserDTO;
use App\DTO\User\UpdateUserDTO;
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

    public function findById($id):JsonResponse
    {
        $obj = $this->userService->findById($id);
        return response()->json(['data' => $obj])->setStatusCode(200);
    }

    public function me():JsonResponse
    {
        $obj = $this->userService->findById(auth()->id());
        return response()->json(['data' => $obj])->setStatusCode(200);
    }

    /**
     * @throws Exception
     */
    public function update(Request $request):JsonResponse
    {
        if($this->userService->update(UpdateUserDTO::makeFromRequest($request)))
            return response()->json(['message' => 'Alterações efetuadas com sucesso!'])->setStatusCode(200);
        return response()->json(['message' => 'Não foi possível salvar os dados, tente novamente.'])->setStatusCode(200);
    }

    /**
     * @throws Exception
     */
    public function create(Request $request):JsonResponse
    {
        if($this->userService->create(CreateUserDTO::makeFromRequest($request)))
            return response()->json(['message' => 'Cadastro efetuado com sucesso!'])->setStatusCode(200);
        return response()->json(['message' => 'Não foi possível salvar os dados, tente novamente.'])->setStatusCode(200);
    }

    public function delete():JsonResponse
    {
        if($this->userService->delete())
            return response()->json(['message' => 'Conta deletada com sucesso'])->setStatusCode(200);
        return response()->json(['message' => 'Não foi possível deletar sua conta no momento, tente novamente mais tarde'])->setStatusCode(400);
    }

}
