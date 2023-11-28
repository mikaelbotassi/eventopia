<?php

namespace App\Services;

use App\DTO\Event\EventDTO;
use App\DTO\DTO;
use App\Models\Event;
use Exception;
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

    public function getAllWithFilter(array $filters):Collection{
        $query = Event::query();

        foreach ($filters as $filter){
            $query->where($filter['column'],$filter['operator'],$filter['value']);
        }

        return EventDTO::toDTOs($query->get());

    }

    public function findById(int $id):DTO{
        return EventDTO::toDTO(Event::findByOrFail($id));
    }

    public function create(DTO $eventDto):bool{
        $obj = new Event();
        $arr = $eventDto->toArray();
        foreach ($arr as $name => $value)
            if($value != null) $obj->$name = $value;
        $obj->owner = auth()->id();
        return $obj->save();
    }

    /**
     * @throws Exception
     */
    public function update(DTO $eventDto, int $id):bool{
        $obj = Event::findByOrFail($id);
        $arr = $eventDto->toArray();

        if($obj->owner != auth()->id())
            throw new Exception("You do not have privileges to perform this action", 401);

        foreach ($arr as $name => $value)
            if($value != null) $obj->$name = $value;
        return $obj->save();
    }

    /**
     * @throws Exception
     */
    public function delete(int $id):bool{
        $obj = Event::findByOrFail($id);

        if($obj->owner != auth()->id())
            throw new Exception("You do not have privileges to perform this action", 401);

        return $obj->delete();
    }

}
