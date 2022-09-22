<?php

namespace Domain\Organisation\Models;

use Domain\Files\Models\Document;
use Domain\Organisation\Events\DepartmentCreated;
use Domain\Organisation\Events\DepartmentDeleted;
use Domain\Organisation\Events\DepartmentUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Support\Concerns\Unguarded;

class Department extends Model
{
    use HasFactory;
    use Unguarded;

    protected $dispatchesEvents = [
        'created' => DepartmentCreated::class,
        'updated' => DepartmentUpdated::class,
        'deleted' => DepartmentDeleted::class
    ];

    public function head(): HasOne
    {
        return $this->hasOne(Person::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(Person::class);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
