<?php

namespace Support\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Support\Casts\ReportConditionSets;
use Support\Concerns\Unguarded;
use Support\QueryBuilders\ReportQueryBuilder;

class Report extends Model
{
    use HasFactory;
    use Unguarded;
    use SoftDeletes;

    protected $casts = [
        'condition_sets' => ReportConditionSets::class
    ];

    public static function query(): Builder|ReportQueryBuilder
    {
        return parent::query();
    }

    public function newEloquentBuilder($query): ReportQueryBuilder
    {
        return new ReportQueryBuilder($query);
    }
}
