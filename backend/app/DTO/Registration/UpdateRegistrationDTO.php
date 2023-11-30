<?php

namespace App\DTO\Registration;
use App\DTO\DTO;

class UpdateRegistrationDTO extends DTO
{
    public int|null $event_id;

    public function __construct()
    {
        parent::__construct([]);
    }

}
