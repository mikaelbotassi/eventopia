<?php

namespace App\Services;

use App\DTO\DTO;
use App\DTO\Registration\RegistrationDTO;
use App\Models\Registration;
use Illuminate\Support\Collection;

class RegistrationService
{
    public function getAll(DTO $dtoClass,Collection $filters = new Collection()):Collection{
        $query = Registration::query();

        foreach ($filters as $column => $value){
            $query->where($column, $value);
        }

        return $dtoClass::toDTOs($query->get());

    }

    public function findById(int $id):DTO{
        return RegistrationDTO::toDTO(Registration::findByOrFail($id));
    }

    public function create(DTO $objDto):bool{
        $obj = new Registration();
        $arr = $objDto->toArray();
        foreach ($arr as $name => $value)
            if($value != null) $obj->$name = $value;
        return $obj->save();
    }

    public function update(DTO $objDto, int $id):bool{
        $obj = Registration::findByOrFail($id);
        $arr = $objDto->toArray();
        foreach ($arr as $name => $value)
            if($value != null) $obj->$name = $value;
        return $obj->save();
    }

    public function delete(int $id):bool{
        $obj = Registration::findByOrFail($id);
        return $obj->delete();
    }

}
