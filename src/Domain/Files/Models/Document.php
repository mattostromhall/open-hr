<?php

namespace Domain\Files\Models;

use Domain\Files\Collections\DocumentCollection;
use Domain\Files\Enums\DocumentableType;
use Domain\Files\Events\DocumentCreated;
use Domain\Files\Events\DocumentDeleted;
use Domain\Files\Events\DocumentUpdated;
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

    protected $dispatchesEvents = [
        'created' => DocumentCreated::class,
        'updated' => DocumentUpdated::class,
        'deleted' => DocumentDeleted::class
    ];

    protected $appends = ['path'];

    public static function query(): Builder|DocumentQueryBuilder
    {
        return parent::query();
    }

    public function newEloquentBuilder($query): DocumentQueryBuilder
    {
        return new DocumentQueryBuilder($query);
    }

    public function newCollection(array $models = []): DocumentCollection
    {
        return new DocumentCollection($models);
    }

    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }

    protected function location(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['directory'] . '/' . $attributes['name'] . '.' . $attributes['extension']
        );
    }

    protected function path(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => '/documents/download' . $attributes['directory'] . '/' . $attributes['name'] . '.' . $attributes['extension']
        );
    }
}
