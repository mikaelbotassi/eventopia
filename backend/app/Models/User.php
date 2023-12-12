<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Utils\Database\EloquentFindable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string id
 * @property string name
 * @property string cpf_cnpj
 * @property string email
 * @property string password
 * @property int[] categories
 * @property Certificate[] certificates
 * @property Gallery img
 * @property int gallery_id
 * @property Feedback[] feedbacks
 * @method static where(string $string, mixed $user_id)
 */
class User extends Authenticatable implements JWTSubject
{

    use HasApiTokens, HasFactory, Notifiable, EloquentFindable, SoftDeletes;
    protected array $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'birth'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $with = ['img'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function categories():BelongsToMany{
        return $this->belongsToMany(Category::class, 'user_categories');
    }

    public function feedbacks():HasMany{
        return $this->hasMany(Feedback::class, 'user_id', 'id');
    }
    public function img():BelongsTo{
        return $this->belongsTo(Gallery::class, 'gallery_id', 'id');
    }

}
