<?php

namespace App\DTO\Certificate;
use App\DTO\DTO;
use App\Models\Event;
use App\Models\Registration;

class CertificateDTO extends DTO
{
    public int|null $id;
    public Registration $registration;
    public int $code;
    public string $created_at;

    public function __construct()
    {
        parent::__construct([]);
    }

}
