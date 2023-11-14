<?php

namespace App\DTO\Certificate;
use App\DTO\DTO;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;

class CertificateDTO extends DTO
{
    public int|null $id;
    public User $user;
    public Event $event;
    public int $code;
    public string $created_at;

    public function __construct()
    {
        parent::__construct([]);
    }

}
