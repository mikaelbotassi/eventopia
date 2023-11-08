<?php

namespace App\DTO;
use Illuminate\Http\Request;

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

    public function toArray() : array
    {
        return get_object_vars($this);
    }

}
