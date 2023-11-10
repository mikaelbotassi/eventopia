<?php

namespace App\Services;

use App\DTO\Event\EventDTO;
use App\DTO\DTO;
use App\Models\Event;
use Illuminate\Support\Collection;

class EventService
{
    public function getAll(DTO $dtoClass,Collection $filters = new Collection()):Collection{
        $query = Event::query();

        foreach ($filters as $column => $value){
            $query->where($column, $value);
        }

        return $dtoClass::toDTOs($query->get());

    }

    public function findById(int $id):DTO{
        return EventDTO::toDTO(Event::findByOrFail($id));
    }

    public function create(DTO $eventDto):bool{
        $obj = new Event();
        $arr = $eventDto->toArray();
        foreach ($arr as $name => $value)
            if($value != null) $obj->$name = $value;
        return $obj->save();
    }

    public function update(DTO $eventDto, int $id):bool{
        $obj = Event::findByOrFail($id);
        $arr = $eventDto->toArray();
        foreach ($arr as $name => $value)
            if($value != null) $obj->$name = $value;
        return $obj->save();
    }

    public function delete(int $id):bool{
        $obj = Event::findByOrFail($id);
        return $obj->delete();
    }

}
