<?php

namespace App\DTO\Category;

use App\DTO\DTO;

class GetCategoryDTO extends DTO
{
    public string|null $name;
    public int|null $id;

    public function __construct()
    {
        parent::__construct([]);
    }


    /**
     * @param string $name
     */
}
