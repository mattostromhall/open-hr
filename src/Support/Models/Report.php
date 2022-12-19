<?php

namespace Support\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Support\Casts\ReportConditionSets;
use Support\Concerns\Unguarded;
use Support\QueryBuilders\ReportQueryBuilder;
use UnexpectedValueException;

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

    public static function FQCN(string $model): string
    {
        if (is_a($model, Model::class, true)) {
            return $model;
        }

        $FQCN = config('app.reportable')[$model];

        if (! $FQCN) {
            throw new UnexpectedValueException("No Matching Fully Qualified Class Name found for {$model}");
        }

        return $FQCN;
    }
}
