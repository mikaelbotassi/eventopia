<?php

namespace App\DTO\User;
use App\DTO\DTO;
use App\Models\Category;
use App\Models\Gallery;
use Illuminate\Database\Eloquent\Collection;

class UserDTO extends DTO
{
    public string|null $name;
    public string|null $email;
    public string|null $cpf_cnpj;
    public string|null $birth;

    public array|null $categories = [];
    public Gallery|null $img = null;
    public Collection|null $feedbacks = null;

    public function __construct()
    {
        parent::__construct([]);
    }

}
