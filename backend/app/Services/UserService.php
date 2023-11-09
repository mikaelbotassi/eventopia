<?php

namespace App\Services;

use App\DTO\User\CreateUserDTO;
use App\DTO\User\UserDTO;
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

    public function findById(int $id):Model{
        return User::findByOrFail($id);
    }

    /**
     * @throws \Exception
     */
    public function update(UserDTO $user):bool{
        $obj = User::findByOrFail(auth()->user()->id);
        $arr = $user->toArray();
        foreach ($arr as $name => $value)
            if($value != null) $obj->$name = $value;
        return $obj->save();
    }

    public function create(CreateUserDTO $user):bool{
        $obj = new User();
        $user->password = Hash::make($user->password);
        $arr = $user->toArray();
        foreach ($arr as $name => $value)
            if($value != null) $obj->$name = $value;
        return $obj->save();
    }

}
