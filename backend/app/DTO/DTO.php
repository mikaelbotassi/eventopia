<?php

namespace App\DTO;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

abstract class DTO
{

    protected array|null $validations;

    public function __construct($validations)
    {
        $this->validations = $validations;
    }


    public static function makeFromRequest(Request $request) : self
    {
        $childClass = get_called_class();
        $attributes = get_class_vars($childClass);

        $new = new $childClass();
        $request->validate($new->validations);

        foreach ($attributes as $name => $value){
            $new->$name = $request->input($name, null);
        }

        return $new;
    }

    public static function toDTOs(Collection $collection) : Collection {
        $newDto = new Collection();
        $dtoClass = get_called_class();
        foreach ($collection as $value){
            $objDto = new $dtoClass();
            foreach (get_class_vars($dtoClass) as $key => $var){
                if(property_exists($objDto, $key) && isset($value->$key)){
//                    if($key = "owner") dd($value->$key);
                    $objDto->$key = $value->$key;
                }
            }
            $newDto->add($objDto);
        }
        return $newDto;
    }

    public static function toDTO(Model $model) : self {
        $dtoClass = get_called_class();
        $objDto = new $dtoClass();
        foreach (get_class_vars($dtoClass) as $key => $var){
            if(property_exists($objDto, $key) && isset($model->$key))
                $objDto->$key = $model->$key;
        }
        return $objDto;
    }

    public function toArray() : array
    {
        return get_object_vars($this);
    }

}
