<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ToDo extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'done_at' => 'datetime',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'done_at',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'todos';

    /**
     * User Relation 1-1
     *
     * @return BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get only user's ToDos
     *
     * @param Builder $query
     * @return Builder
     **/
    public function scopeLoggedUser(Builder $query)
    {
        $userId = auth()->id();

        return $query->where('user_id', $userId);
    }
}
