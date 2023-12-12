<?php

namespace App\Models;

use App\Utils\Database\EloquentFindable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string filename
 * @property string mime
 * @property string path
 * @property string size
 * @method static create(array $input)
 */
class Gallery extends Model
{
    use HasFactory, EloquentFindable;

    protected $fillable = ['filename', 'mime', 'path', 'size'];

}
