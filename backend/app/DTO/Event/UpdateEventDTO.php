<?php

namespace App\DTO\Event;
use App\DTO\DTO;
use App\Models\Category;

class UpdateEventDTO extends DTO
{
    public string|null $event_date;
    public string|null $title;
    public string|null $localization;
    public string|null $urlLocalization;
    public string|null $description;
    public int|null $workload;
    public string|null $registration_validity;
    public function __construct()
    {
        parent::__construct([
            'event_date' => [
                'datetime',
                'nullable',
                'after:yesterday'
            ],
            'localization' => [
                'string',
                'nullable',
                'min:5'
            ],
            'urlLocalization' => [
                'string',
                'nullable',
                'min:5'
            ],
            'description' => [
                'string',
                'nullable',
                'min:5'
            ],
            'workload' => [
                'integer',
                'nullable',
                'gt:0'
            ],
            'registration_validity' => [
                'datetime',
                'nullable',
                'after:yesterday',
            ],
            'owner' => [
                'integer',
                'nullable',
                'exists:users,id',
            ],
        ]);
    }

}
