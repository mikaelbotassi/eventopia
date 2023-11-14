<?php

namespace App\DTO\Feedback;
use App\DTO\DTO;
use App\Models\Category;

class CreateFeedbackDTO extends DTO
{
    public string|null $description;
    public int|null $event_id;

    public function __construct()
    {
        parent::__construct([
            'description' => [
                'string',
                'required',
                'min:3'
            ],
            'event_id' => [
                'integer',
                'gt:0',
                'exists:events,id'
            ]
        ]);
    }

}
