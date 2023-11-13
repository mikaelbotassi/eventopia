<?php

namespace App\DTO\Event;
use App\DTO\DTO;
use App\Models\Category;

class CreateEventDTO extends DTO
{
    public string|null $event_date;
    public string|null $localization;
    public string|null $urlLocalization;
    public string|null $description;
    public int|null $workload;
    public string|null $registration_validity;
    public function __construct()
    {
        parent::__construct([
            'event_date' => [
                'date',
                'required',
                'after:yesterday'
            ],
            'localization' => [
                'string',
                'required',
                'min:5'
            ],
            'urlLocalization' => [
                'string',
                'required',
                'min:5'
            ],
            'description' => [
                'string',
                'required',
                'min:5'
            ],
            'workload' => [
                'integer',
                'required',
                'gt:0'
            ],
            'registration_validity' => [
                'date',
                'required',
                'after:yesterday',
            ],
            'owner' => [
                'integer',
                'required',
                'exists:users,id',
            ],
        ]);
    }

}
