<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Baby extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'birth_date',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'birth_date' => 'datetime',
        'user_id' => 'integer',
    ];

    public function diapers(): HasMany
    {
        return $this->hasMany(Diaper::class);
    }

    public function feedings(): HasMany
    {
        return $this->hasMany(Feeding::class);
    }

    public function sleeps(): HasMany
    {
        return $this->hasMany(Sleep::class);
    }

    public function caregivers(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getHistoryAttribute()
    {
        return $this->feedings->map(function ($item) {
                $item->type = 'feeding';
                return $item;
            })
            ->concat($this->diapers->map(function ($item) {
                $item->type = 'diaper';
                return $item;
            }))
            ->concat($this->sleeps->map(function ($item) {
                $item->type = 'sleep';
                return $item;
            }))
            ->sortByDesc('date_time');
    }
}
