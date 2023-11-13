<?php

namespace App\DTO\Registration;
use App\DTO\DTO;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;

class CreateRegistrationDTO extends DTO
{
    public int $user_id;
    public int $event_id;

    public function __construct()
    {
        parent::__construct([
            'user_id' => [
                'integer',
                'required',
                'gt:0',
                'exists:users,id'
            ],
            'event_id' => [
                'integer',
                'gt:0',
                'required',
                'exists:events,id'
            ]
        ]);
    }

}
