<?php

namespace Domain\Files\Models;

use Domain\Files\Enums\DocumentableType;
use Domain\Files\QueryBuilders\DocumentQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Support\Concerns\Unguarded;

class Document extends Model
{
    use HasFactory;
    use Unguarded;

    protected $casts = [
        'documentable_type' => DocumentableType::class
    ];

    public static function query(): Builder|DocumentQueryBuilder
    {
        return parent::query();
    }

    public function newEloquentBuilder($query): DocumentQueryBuilder
    {
        return new DocumentQueryBuilder($query);
    }

    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }

    protected function location(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['path'] . '/' . $attributes['name']
        );
    }
}
