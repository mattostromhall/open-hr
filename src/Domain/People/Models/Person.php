<?php

namespace Domain\People\Models;

use Domain\Absences\Models\Holiday;
use Domain\Absences\Models\Sickness;
use Domain\Auth\Models\User;
use Domain\Expenses\Models\Expense;
use Domain\Files\Models\Document;
use Domain\Notifications\Models\Notification;
use Domain\Organisation\Models\Department;
use Domain\People\Collections\PersonCollection;
use Domain\People\Enums\RemunerationInterval;
use Domain\People\QueryBuilders\PersonQueryBuilder;
use Domain\Performance\Models\Objective;
use Domain\Performance\Models\OneToOne;
use Domain\Performance\Models\Training;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Support\Concerns\Unguarded;

class Person extends Model
{
    use HasFactory;
    use Unguarded;

    protected $table = 'people';

    protected $casts = [
        'dob' => 'date',
        'remuneration_interval' => RemunerationInterval::class,
        'started_on' => 'date',
        'finished_on' => 'date',
    ];

    protected $appends = ['full_name'];

    public function newEloquentBuilder($query): PersonQueryBuilder
    {
        return new PersonQueryBuilder($query);
    }

    public function newCollection(array $models = []): PersonCollection
    {
        return new PersonCollection($models);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function oneToOnes(): HasMany
    {
        return $this->hasMany(OneToOne::class);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function holidays(): HasMany
    {
        return $this->hasMany(Holiday::class);
    }

    public function objectives(): HasMany
    {
        return $this->hasMany(Objective::class);
    }

    public function sicknesses(): HasMany
    {
        return $this->hasMany(Sickness::class);
    }

    public function training(): HasMany
    {
        return $this->hasMany(Training::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class);
    }

    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->first_name} {$this->last_name}",
        );
    }
}
