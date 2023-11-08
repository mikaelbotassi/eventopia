<?php

namespace App\DTO\User;
use App\DTO\DTO;

class UserDTO extends DTO
{
    public string|null $name;
    public string|null $email;
    public string|null $password;

    public function __construct()
    {
        parent::__construct([
            'name' => [
                'required'
            ]
        ]);
    }


    /**
     * @param string $name
     * @param string $email
     * @param string $password
     */

}
