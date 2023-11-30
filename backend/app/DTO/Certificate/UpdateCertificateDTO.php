<?php

namespace App\DTO\Certificate;
use App\DTO\DTO;
use App\Models\Category;

class UpdateCertificateDTO extends DTO
{
    public int $code;

    public function __construct()
    {
        parent::__construct([
            'code' => [
                'integer',
                'gt:0',
                'required'
            ]
        ]);
    }

}
