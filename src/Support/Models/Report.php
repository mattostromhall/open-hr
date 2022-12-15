<?php

namespace Support\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Support\Casts\ReportConditionSets;
use Support\Concerns\Unguarded;

class Report extends Model
{
    use HasFactory;
    use Unguarded;
    use SoftDeletes;

    protected $casts = [
        'condition_sets' => ReportConditionSets::class
    ];
}
