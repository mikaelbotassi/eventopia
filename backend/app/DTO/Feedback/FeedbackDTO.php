<?php

namespace App\DTO\Feedback;
use App\DTO\DTO;
use App\Models\Category;
use App\Models\User;

class FeedbackDTO extends DTO
{
    public int|null $id;
    public string|null $descricao;
    public User|null $autor;
    public string|null $created_at;

    public function __construct()
    {
        parent::__construct([]);
    }

}
