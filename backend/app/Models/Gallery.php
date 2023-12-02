<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $input)
 */
class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['filename', 'mime', 'path', 'size'];

}
