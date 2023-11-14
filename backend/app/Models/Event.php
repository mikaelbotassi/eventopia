<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Utils\Database\EloquentFindable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int id
 * @property string event_date
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
    use EloquentFindable;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function ownerObj():BelongsTo{
        return $this->belongsTo(User::class, 'owner', 'id');
    }

    public function registrations():BelongsToMany{
        return $this->belongsToMany(User::class, 'registrations');
    }

}
