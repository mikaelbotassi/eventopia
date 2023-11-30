<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Utils\Database\EloquentFindable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int id
 * @property int user_id
 * @property int event_id
 * @property User user
 * @property Event event
 * @property string presence_date
 * @method static where(string $string, int|string|null $id)
 */

class Registration extends Model
{
    protected $table = "registrations";
    use EloquentFindable;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user():BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function event():BelongsTo{
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

}
