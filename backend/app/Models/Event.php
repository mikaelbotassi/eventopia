<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Utils\Database\EloquentFindable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string event_date
 * @property string title
 * @property string localization
 * @property string urlLocalization
 * @property string description
 * @property int workload
 * @property string registration_validity
 * @property User ownerObj
 * @property User registrations
 * @property int owner
 * @method static where(string $string, int $int)
 */

class Event extends Model
{
    protected $table = "events";
    use EloquentFindable, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $with = ['ownerObj'];

    public function ownerObj():BelongsTo{
        return $this->belongsTo(User::class, 'owner', 'id');
    }

    public function registrations():BelongsToMany{
        return $this->belongsToMany(User::class, 'registrations');
    }

    public function categories():BelongsToMany{
        return $this->belongsToMany(Category::class, 'event_categories');
    }

}
