<?php

namespace App\DTO\User;
use App\DTO\DTO;

class CreateUserDTO extends DTO
{
    public string|null $name;
    public string|null $email;
    public string|null $password;
    public string|null $birth;

    public function __construct()
    {
        parent::__construct([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            'email' => [
                'required',
                'string',
                'min:10',
                'unique:users',
                'max:191'
            ],
            'password' => [
                'string',
                'max:20'
            ],
        ]);
    }

}
