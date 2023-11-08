<?php

namespace App\DTO\Category;

use App\DTO\DTO;

class CategoryDTO extends DTO
{
    public string|null $name;

    public function __construct()
    {
        parent::__construct([
            'name' => [
                'required'
            ]
        ]);
    }


    /**
     * @param string $name
     */
}
