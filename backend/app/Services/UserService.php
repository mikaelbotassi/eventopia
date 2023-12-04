<?php

namespace App\Services;

use App\DTO\DTO;
use App\DTO\User\CreateUserDTO;
use App\DTO\User\GetUserDTO;
use App\DTO\User\UpdateUserDTO;
use App\DTO\User\UserDTO;
use App\Models\Category;
use App\Models\User;
use App\Utils\Functions;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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

    /**
     * @throws Exception
     */
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

        if(isset($arr['cpf_cnpj'])) {
            $arr['cpf_cnpj'] = Functions::onlyNumbers($arr['cpf_cnpj']);
            if(!$this->isCpfUnique($arr['cpf_cnpj'])) return false;

            if(!$this->validateCpf($arr)) return false;
        }

        if(!$obj->save()) return false;

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
    public function create(CreateUserDTO $user):bool{
        $obj = new User();
        $user->password = Hash::make($user->password);

        $arr = $user->toArray();

        $categories = null;

        if(isset($arr['categories'])){
            $categories = $arr['categories'];
            unset($arr['categories']);
        }

        foreach ($arr as $name => $value)
            if($value != null) $obj->$name = $value;

        $arr['cpf_cnpj'] = Functions::onlyNumbers($arr['cpf_cnpj']);

        if(!$this->isCpfUnique($arr['cpf_cnpj'])) return false;

        if(!$this->validateCpf($arr)) return false;

        $obj->cpf_cnpj = $arr['cpf_cnpj'];

        if(!$obj->save()) return false;

        if($categories){
            $obj->categories()->detach();
            foreach ($categories as $arrObj){
                $obj->categories()->attach(Category::findByOrFail($arrObj['id']));
            }
        }

        return true;
    }

    public function delete():bool{
        $obj = User::findByOrFail(auth()->id());
        return $obj->delete();
    }

    /**
     * @throws Exception
     */
    private function validateCpf(array $arr):bool{
        if(strlen($arr['cpf_cnpj']) < 11 ||
        (strlen($arr['cpf_cnpj']) > 11 && !Functions::cnpjValid($arr['cpf_cnpj'])) ||
        (strlen($arr['cpf_cnpj']) == 11 && !Functions::cpfValid($arr['cpf_cnpj']))){
            throw new Exception('O CPF ou CNPJ inserido é inválido.',422);
        }
        return true;
    }

    /**
     * @throws Exception
     */
    private function isCpfUnique(string $cpf):bool{
        if(User::where('cpf_cnpj', $cpf)->where('id','<>',auth()->id())->exists()){
            throw new Exception('O CPF ou CNPJ inserido já está sendo utilizado.',422);
        }
        return true;
    }

}
