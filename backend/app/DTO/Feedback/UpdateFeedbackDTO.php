<?php

namespace App\DTO\Feedback;
use App\DTO\DTO;
use App\Models\Category;

class UpdateFeedbackDTO extends DTO
{
    public string|null $descricao;

    public function __construct()
    {
        parent::__construct([]);
    }

}
