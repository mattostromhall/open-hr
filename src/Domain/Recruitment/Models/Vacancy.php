<?php

namespace Domain\Recruitment\Models;

use Domain\People\Models\Person;
use Domain\Recruitment\Enums\ContractType;
use Domain\Recruitment\Events\VacancyCreated;
use Domain\Recruitment\Events\VacancyDeleted;
use Domain\Recruitment\Events\VacancyUpdated;
use Domain\Recruitment\QueryBuilders\VacancyQueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Domain\Files\Models\Document;
use Illuminate\Database\Eloquent\SoftDeletes;
use Support\Casts\HTML;
use Support\Casts\Money;
use Support\Concerns\Reporting;
use Support\Concerns\Unguarded;
use Support\Enums\Currency;

class Vacancy extends Model
{
    use HasFactory;
    use Unguarded;
    use SoftDeletes;
    use Reporting;

    protected $casts = [
        'description' => HTML::class,
        'contract_type' => ContractType::class,
        'remuneration' => Money::class,
        'remuneration_currency' => Currency::class,
        'open_at' => 'datetime',
        'close_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'created' => VacancyCreated::class,
        'updated' => VacancyUpdated::class,
        'deleted' => VacancyDeleted::class
    ];

    public static function query(): Builder|VacancyQueryBuilder
    {
        return parent::query();
    }

    public function newEloquentBuilder($query): VacancyQueryBuilder
    {
        return new VacancyQueryBuilder($query);
    }

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

    public function contactEmail(): string
    {
        return $this->contact->email;
    }
}
