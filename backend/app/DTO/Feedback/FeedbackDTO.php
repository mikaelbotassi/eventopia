<?php

namespace App\DTO\Feedback;
use App\DTO\DTO;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;

class FeedbackDTO extends DTO
{
    public int|null $id;
    public string|null $description;
    public User|null $author;
    public Event|null $event;
    public string|null $created_at;

    public function __construct()
    {
        parent::__construct([]);
    }

}
