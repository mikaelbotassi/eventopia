<?php

namespace App\Services;

use App\DTO\DTO;
use App\DTO\User\CreateUserDTO;
use App\DTO\User\GetUserDTO;
use App\DTO\User\UpdateUserDTO;
use App\DTO\User\UserDTO;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAll(Collection $filters = new Collection()):Collection{
        $query = User::query();

        foreach ($filters as $column => $value){
            $query->where($column, $value);
        }

        return $query->get();
    }

    public function findById(int|string $id):DTO{
        return GetUserDTO::toDTO(User::findByOrFail($id));
    }

    public function update(DTO $user):bool{
        $obj = User::findByOrFail(auth()->user()->id);
        $arr = $user->toArray();
        $categories = null;

        if(isset($arr['categories'])){
            $categories = $arr['categories'];
            unset($arr['categories']);
        }

        foreach ($arr as $name => $value)
            if($value != null) $obj->$name = $value;

        $obj->save();

        if($categories){
            $obj->categories()->detach();
            foreach ($categories as $key => $arrObj){
                $obj->categories()->attach(Category::findByOrFail($arrObj['id']));
            }
        }
        return true;

    }

    public function create(CreateUserDTO $user):bool{
        $obj = new User();
        $user->password = Hash::make($user->password);
        $arr = $user->toArray();
        $categories = $arr['categories'];
        unset($arr['categories']);

        foreach ($arr as $name => $value)
            if($value != null) $obj->$name = $value;

        $obj->save();

        if(!$categories) return true;

        foreach ($categories as $key => $arrObj){
            $obj->categories()->attach(Category::findByOrFail($arrObj['id']));
        }
        return true;
    }

    public function delete():bool{
        $obj = User::findByOrFail(auth()->id());
        return $obj->delete();
    }

}
