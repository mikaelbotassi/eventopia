<?php

namespace App\DTO\User;
use App\DTO\DTO;
use App\Models\User;
use App\Utils\Functions;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;

class UpdateUserDTO extends DTO
{
    public string|null $name;
    public int|null $gallery_id;
    public string|null $email;
    public string|null $cpf_cnpj;
    public string|null $password;
    public string|null $birth;
    public array|null $categories = [];

    public function __construct()
    {
        parent::__construct([
            'name' => [
                'nullable',
                'string',
                'min:3',
                'max:255'
            ],
            'cpf_cnpj' => [
                'nullable',
                'string',
                'min:11',
                'max:20'
            ],
            'email' => [
                'nullable',
                'string',
                'min:10',
                Rule::unique('users')->ignore(auth()->id()),
                'max:191'
            ],
            'password' => [
                'nullable',
                'string',
                'max:20'
            ],
            'categories' => [
                'nullable',
                'array'
            ],
            'categories.*.id' => [
                'exists:categories,id'
            ],
            'gallery_id' => [
                'nullable',
                'exists:galleries,id'
            ]
        ]);
    }

}
