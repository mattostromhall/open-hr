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
use Domain\People\Events\PersonCreated;
use Domain\People\Events\PersonDeleted;
use Domain\People\Events\PersonUpdated;
use Domain\People\QueryBuilders\PersonQueryBuilder;
use Domain\Performance\Models\Objective;
use Domain\Performance\Models\OneToOne;
use Domain\Performance\Models\Training;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Support\Concerns\Unguarded;
use Support\Enums\Currency;

class Person extends Model
{
    use HasFactory;
    use Unguarded;
    use SoftDeletes;

    protected $table = 'people';

    protected $casts = [
        'dob' => 'date',
        'remuneration_interval' => RemunerationInterval::class,
        'remuneration_currency' => Currency::class,
        'started_on' => 'date',
        'finished_on' => 'date',
    ];

    protected $dispatchesEvents = [
        'created' => PersonCreated::class,
        'updated' => PersonUpdated::class,
        'deleted' => PersonDeleted::class
    ];

    protected $appends = ['full_name'];

    public static function query(): Builder|PersonQueryBuilder
    {
        return parent::query();
    }

    public function newEloquentBuilder($query): PersonQueryBuilder
    {
        return new PersonQueryBuilder($query);
    }

    public function newCollection(array $models = []): PersonCollection
    {
        return new PersonCollection($models);
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function oneToOnes(): HasMany
    {
        return $this->hasMany(OneToOne::class);
    }

    public function managerOneToOnes(): HasMany
    {
        return $this->hasMany(OneToOne::class, 'manager_id');
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
        return $this->belongsTo(self::class);
    }

    public function directReports(): HasMany
    {
        return $this->hasMany(self::class, 'manager_id');
    }

    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable')->orderByDesc('created_at');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isManagerFor(self $person): bool
    {
        return $person->manager_id === $this->id;
    }

    public function isHeadOfDepartmentFor(self $person): bool
    {
        return $person->department?->isHead($this) ?? false;
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->first_name} {$this->last_name}",
        );
    }
}
