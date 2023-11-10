<?php

namespace App\DTO\User;
use App\DTO\DTO;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class GetUserDTO extends DTO
{
    public string|null $name;
    public string|null $email;
    public string|null $password;
    public string|null $birth;

    public Collection|null $categories = null;
    public Collection|null $feedbacks = null;

    public function __construct()
    {
        parent::__construct([]);
    }

}
