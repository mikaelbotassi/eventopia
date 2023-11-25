<?php

namespace App\DTO\Event;
use App\DTO\DTO;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class EventDTO extends DTO
{
    public int|null $id;
    public string|null $title;
    public string|null $event_date;
    public string|null $localization;
    public string|null $urlLocalization;
    public string|null $description;
    public int|null $workload;
    public string|null $registration_validity;
    public User|null $ownerObj;
    public Collection|null $registrations;
    public string|null $created_at;

    public function __construct()
    {
        parent::__construct([]);
    }

}
