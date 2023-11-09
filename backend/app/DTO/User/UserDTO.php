<?php

namespace App\DTO\User;
use App\DTO\DTO;

class UserDTO extends DTO
{
    public string|null $name;
    public string|null $email;
    public string|null $password;
    public string|null $birth;

    public function __construct()
    {
        parent::__construct([]);
    }

}
