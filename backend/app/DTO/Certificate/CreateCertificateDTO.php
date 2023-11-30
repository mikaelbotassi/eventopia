<?php

namespace App\DTO\Certificate;
use App\DTO\DTO;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;

class CreateCertificateDTO extends DTO
{
    public int $registration_id;
    public int $code;

    public function __construct()
    {
        parent::__construct([
            'registration_id' => [
                'integer',
                'gt:0',
                'required',
                'exists:registrations,id'
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
