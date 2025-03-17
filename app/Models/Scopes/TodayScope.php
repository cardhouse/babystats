<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TodayScope implements Scope
{
    /**
     * Scope all queries to where the date_time is today.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->whereDate('date_time', today());
    }
}
