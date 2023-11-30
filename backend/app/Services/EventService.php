<?php

namespace App\Services;

use App\DTO\Event\EventDTO;
use App\DTO\DTO;
use App\Models\Category;
use App\Models\Event;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EventService
{
    public function getAll(DTO $dtoClass,Collection $filters = new Collection()):Collection{
        $query = Event::query();
        $userId =auth()->id();
        if(auth()->check()){
            $query->leftJoin('event_categories', 'events.id', '=', 'event_categories.event_id')
            ->leftJoin('user_categories', function ($join) use ($userId) {
                $join->on('event_categories.category_id', '=', 'user_categories.category_id')
                    ->where('user_categories.user_id', '=', $userId)
                    ->orWhereNull('user_categories.user_id');
            })
            ->select('events.*')
            ->selectRaw('COUNT(user_categories.category_id) as categories_in_common')
            ->whereNull('events.deleted_at')
            ->groupBy('events.id')
            ->orderByDesc('categories_in_common')
            ->orderBy('events.id');
        }

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

        $categories = null;
        if(isset($arr['categories'])) {
            $categories = $arr['categories'];
            unset($arr['categories']);
        }

        foreach ($arr as $name => $value)
            if($value != null) $obj->$name = $value;
        $obj->owner = auth()->id();

        if(!$obj->save()) return false;

        if($categories){
            foreach ($categories as $arrObj){
                $obj->categories()->attach(Category::findByOrFail($arrObj['id']));
            }
        }

        return true;
    }

    /**
     * @throws Exception
     */
    public function update(DTO $eventDto, int $id):bool{
        $obj = Event::findByOrFail($id);
        $arr = $eventDto->toArray();

        if($obj->owner != auth()->id())
            throw new Exception("You do not have privileges to perform this action", 403);

        $categories = null;
        if(isset($arr['categories'])) {
            $categories = $arr['categories'];
            unset($arr['categories']);
        }

        foreach ($arr as $name => $value)
            if($value != null) $obj->$name = $value;

        $obj->save();

        if($categories){
            $obj->categories()->detach();
            foreach ($categories as $arrObj){
                $obj->categories()->attach(Category::findByOrFail($arrObj['id']));
            }
        }
        return true;
    }

    /**
     * @throws Exception
     */
    public function delete(int $id):bool{
        $obj = Event::findByOrFail($id);

        if($obj->owner != auth()->id())
            throw new Exception("You do not have privileges to perform this action", 403);

        return $obj->delete();
    }

}
