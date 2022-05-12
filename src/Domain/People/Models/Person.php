<?php

namespace Domain\People\Models;

use Domain\Absences\Models\Holiday;
use Domain\Absences\Models\Sickness;
use Domain\Expenses\Models\Expense;
use Domain\Files\Models\Document;
use Domain\Notifications\Models\Notification;
use Domain\Organisation\Models\Department;
use Domain\People\Enums\RemunerationInterval;
use Domain\Performance\Models\Objective;
use Domain\Performance\Models\OneToOne;
use Domain\Performance\Models\Training;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Shared\Models\User;
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
}
