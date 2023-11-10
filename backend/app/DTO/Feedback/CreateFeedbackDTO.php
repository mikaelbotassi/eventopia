<?php

namespace App\DTO\Feedback;
use App\DTO\DTO;
use App\Models\Category;

class CreateFeedbackDTO extends DTO
{
    public string|null $descricao;
    public int|null $user_id;

    public function __construct()
    {
        parent::__construct([
            'descricao' => [
                'string',
                'required',
                'min:3'
            ],
            'user_id' => [
                'integer',
                'gt:0',
                'exists:users,id'
            ]
        ]);
    }

}
