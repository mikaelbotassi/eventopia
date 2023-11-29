<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function validatePassword(string $password):bool
    {
        if($password != ''
            && Hash::check($password,auth()->user()->getAuthPassword())) return true;
        return false;
    }
}
