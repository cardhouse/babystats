<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Diaper extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'date_time',
        'baby_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'date_time' => 'datetime',
        'baby_id' => 'integer',
    ];

    public function baby(): BelongsTo
    {
        return $this->belongsTo(Baby::class);
    }

    public function scopeToday($query)
    {
        $startOfDay = Carbon::now()->startOfDay();
        $endOfDay = Carbon::now()->endOfDay();

        return $query->whereBetween('date_time', [$startOfDay, $endOfDay]);
    }
}
