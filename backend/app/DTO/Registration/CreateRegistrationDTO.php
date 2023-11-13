<?php

namespace App\DTO\Registration;
use App\DTO\DTO;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;

class CreateRegistrationDTO extends DTO
{
    public int $event_id;

    public function __construct()
    {
        parent::__construct([
            'event_id' => [
                'integer',
                'gt:0',
                'required',
                'exists:events,id'
            ]
        ]);
    }

}
