<?php

namespace App\DTO\User;
use Illuminate\Http\Request;
class UserDTO extends DTO
{
    public string|null $name;
    public string|null $email;
    public string|null $password;

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     */

}
