<?php

namespace App\DTO\User;
use App\DTO\DTO;
use Illuminate\Database\Eloquent\Collection;

class CreateUserDTO extends DTO
{
    public string|null $name;
    public string|null $email;
    public string|null $cpf_cnpj;
    public string|null $password;
    public string|null $birth;
    public array|null $categories = [];



    public function __construct()
    {
        parent::__construct([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255'
            ],
            'cpf_cnpj' => [
                'required',
                'string',
                'min:11',
                'max:20'
            ],
            'email' => [
                'required',
                'string',
                'min:10',
                'unique:users,email',
                'max:191'
            ],
            'password' => [
                'string',
                'max:20'
            ],
            'categories' => [
                'nullable',
                'array'
            ],
            'categories.*.id' => [
                'exists:categories,id'
            ]
        ]);
    }

}
