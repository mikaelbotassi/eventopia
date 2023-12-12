<?php

namespace App\DTO\Registration;
use App\DTO\DTO;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;

class RegistrationDTO extends DTO
{
    public int|null $id;
    public User $user;
    public Event $event;
    public string $presence_date;
    public string $created_at;

    public function __construct()
    {
        parent::__construct([]);
    }

}
