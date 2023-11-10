<?php

namespace App\Services;

use App\DTO\Feedback\FeedbackDTO;
use App\DTO\DTO;
use App\Models\Feedback;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class FeedbackService
{
    public function getAll(DTO $dtoClass,Collection $filters = new Collection()):Collection{
        $query = Feedback::query();

        foreach ($filters as $column => $value){
            $query->where($column, $value);
        }

        return $dtoClass::toDTOs($query->get());

    }

    public function findById(int $id):DTO{
        return FeedbackDTO::toDTO(Feedback::findByOrFail($id));
    }

    public function create(DTO $feedbackDTO):bool{
        $obj = new Feedback();
        $arr = $feedbackDTO->toArray();
        foreach ($arr as $name => $value)
            if($value != null) $obj->$name = $value;
        return $obj->save();
    }

    public function update(DTO $feedbackDTO, int $id):bool{
        $obj = Feedback::findByOrFail($id);
        $arr = $feedbackDTO->toArray();
        foreach ($arr as $name => $value)
            if($value != null) $obj->$name = $value;
        return $obj->save();
    }

    public function delete(int $id):bool{
        $obj = Feedback::findByOrFail($id);
        return $obj->delete();
    }

}
