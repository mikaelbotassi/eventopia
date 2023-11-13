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
    public bool $is_present;
    public string $created_at;

    public function __construct()
    {
        parent::__construct([]);
    }

}
