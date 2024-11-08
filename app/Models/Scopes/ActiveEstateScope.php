<?php

namespace App\Models\Scopes;

use App\Constants\RealEstateConstants;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ActiveEstateScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where($model->getTable() . ".status", RealEstateConstants::STATUS_ACTIVE);
    }
}
