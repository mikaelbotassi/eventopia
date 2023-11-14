<?php

namespace App\DTO\Certificate;
use App\DTO\DTO;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;

class CreateCertificateDTO extends DTO
{
    public int $user_id;
    public int $event_id;
    public int $code;

    public function __construct()
    {
        parent::__construct([
            'event_id' => [
                'integer',
                'gt:0',
                'required',
                'exists:events,id'
            ],
            'user_id' => [
                'integer',
                'gt:0',
                'required',
                'exists:users,id'
            ],
            'code' => [
                'integer',
                'gt:0',
                'required',
                'unique:certificates',
            ]
        ]);
    }

}
