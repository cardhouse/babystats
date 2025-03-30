<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

    public function getHistoryAttribute(): Collection
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

    public function getHistoryForDate(?string $date = null, ?string $timezone = 'America/New_York'): Collection
    {
        if (! $date) {
            $date = now()->setTimezone($timezone)->format('Y-m-d');
        }

        $startOfDay = \Carbon\Carbon::createFromFormat('Y-m-d', $date, $timezone)
            ->startOfDay()
            ->utc();
        $endOfDay = \Carbon\Carbon::createFromFormat('Y-m-d', $date, $timezone)
            ->endOfDay()
            ->utc();

        $feedingsQuery = $this->feedings()
            ->selectRaw("id, category, amount, unit, side, date_time, 'feeding' as type")
            ->whereBetween('date_time', [$startOfDay, $endOfDay]);

        $diapersQuery = $this->diapers()
            ->selectRaw("id, category, NULL as amount, NULL as unit, NULL as side, date_time, 'diaper' as type")
            ->whereBetween('date_time', [$startOfDay, $endOfDay]);

        $sleepsQuery = $this->sleeps()
            ->selectRaw("id, NULL as category, NULL as amount, NULL as unit, NULL as side, date_time, 'sleep' as type")
            ->whereBetween('date_time', [$startOfDay, $endOfDay]);

        $unionQuery = $feedingsQuery->unionAll($diapersQuery)->unionAll($sleepsQuery);

        $history = DB::query()
            ->fromSub($unionQuery, 'history')
            ->orderByDesc('date_time')
            ->get();

        return collect($history);
    }
}
