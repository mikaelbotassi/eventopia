<?php

namespace App\DTO\Registration;
use App\DTO\DTO;
use App\Models\Category;

class UpdateRegistrationDTO extends DTO
{
    public int|null $user_id;
    public int|null $event_id;

    public function __construct()
    {
        parent::__construct([]);
    }

}
