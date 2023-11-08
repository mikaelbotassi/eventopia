<?php

namespace App\Services;

use App\DTO\Category\CategoryDTO;
use App\DTO\DTO;
use App\DTO\User\UserDTO;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CategoryService
{
    public function getAll(Collection $filters = new Collection()):Collection{
        $query = Category::query();

        foreach ($filters as $column => $value){
            $query->where($column, $value);
        }

        return $query->get();
    }

    public function findById(int $id):Model{
        return Category::findByOrFail($id);
    }

    public function create(DTO $categoryDTO):bool{
        $obj = new Category();
        $arr = $categoryDTO->toArray();
        foreach ($arr as $name => $value)
            if($value != null) $obj->$name = $value;
        return $obj->save();
    }

    public function update(CategoryDTO $categoryDTO, int $id):bool{
        $obj = Category::findByOrFail($id);
        $arr = $categoryDTO->toArray();
        foreach ($arr as $name => $value)
            if($value != null) $obj->$name = $value;
        return $obj->save();
    }

}
