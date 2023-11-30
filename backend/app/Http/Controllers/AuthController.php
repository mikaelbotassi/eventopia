<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    private AuthService $authService;
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'refresh']]);
        $this->authService = new AuthService();
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'E-mail ou senha inválidos',
                'error' => 'Unauthorized'
            ], 401);
        }

        return $this->respondWithToken($token, 'Login efetuado com sucesso');
    }

    public function validatePassword(Request $request):JsonResponse
    {
        $request->validate(['password' => 'required|string|max:20']);
        if($this->authService->validatePassword($request->input('password')))
            return response()->json(['message' => 'Senha válida'])->setStatusCode(200);
        return response()->json(['message' => 'Senha inválida'])->setStatusCode(406);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Dados obtidos com sucesso',
            'data' => auth()->user()
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Logout realizado com sucesso!']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $message = ''): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'message' => $message,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'expiration_time' => now()->addSeconds(auth()->factory()->getTTL() * 60),
        ]);
    }
}
