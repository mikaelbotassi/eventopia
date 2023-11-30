<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Utils\Database\EloquentFindable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property int registration_id
 * @property Registration registration
 * @property int code
 * @method static where(string $string, int|string|null $id)
 */

class Certificate extends Model
{
    protected $table = "certificates";
    use EloquentFindable;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function registration():BelongsTo{
        return $this->belongsTo(Registration::class, 'registration_id', 'id');
    }

}
