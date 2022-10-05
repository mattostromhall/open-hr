<?php

namespace Domain\Recruitment\Models;

use Domain\People\Models\Person;
use Domain\Recruitment\Enums\ContractType;
use Domain\Recruitment\Events\VacancyCreated;
use Domain\Recruitment\Events\VacancyDeleted;
use Domain\Recruitment\Events\VacancyUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Domain\Files\Models\Document;
use Support\Concerns\Unguarded;
use Support\Enums\Currency;

class Vacancy extends Model
{
    use HasFactory;
    use Unguarded;

    protected $casts = [
        'contract_type' => ContractType::class,
        'remuneration_currency' => Currency::class,
        'open_at' => 'datetime',
        'close_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'created' => VacancyCreated::class,
        'updated' => VacancyUpdated::class,
        'deleted' => VacancyDeleted::class
    ];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'contact_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
