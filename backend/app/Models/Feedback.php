<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Utils\Database\EloquentFindable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int id
 * @property string descricao
 * @property User autor
 * @property string date
 */

class Feedback extends Model
{
    protected $table = "feedbacks";
    use EloquentFindable;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function autor():BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
