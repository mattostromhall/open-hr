<?php

namespace Domain\Recruitment\Models;

use Domain\Recruitment\Events\ApplicationCreated;
use Domain\Recruitment\Events\ApplicationDeleted;
use Domain\Recruitment\Events\ApplicationUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Domain\Files\Models\Document;
use Support\Concerns\Unguarded;

class Application extends Model
{
    use HasFactory;
    use Unguarded;

    protected $dispatchesEvents = [
        'created' => ApplicationCreated::class,
        'updated' => ApplicationUpdated::class,
        'deleted' => ApplicationDeleted::class
    ];

    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(Vacancy::class);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
