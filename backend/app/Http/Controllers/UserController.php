<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(Request $request):JsonResponse
    {
        $obj = User::findByOrFail(auth()->user()->id);
        $obj->name = $request->input('name');
        $obj->save();

        return response()->json([
            'message' => 'User updated successfully'
        ])->setStatusCode(200);
    }
}
