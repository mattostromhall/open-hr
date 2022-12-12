<?php

namespace Domain\Recruitment\Models;

use Domain\Recruitment\Enums\ApplicationStatus;
use Domain\Recruitment\Events\ApplicationCreated;
use Domain\Recruitment\Events\ApplicationDeleted;
use Domain\Recruitment\Events\ApplicationUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Domain\Files\Models\Document;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Support\Concerns\Reporting;
use Support\Concerns\Unguarded;

class Application extends Model
{
    use HasFactory;
    use Unguarded;
    use SoftDeletes;
    use Reporting;

    protected $casts = [
        'status' => ApplicationStatus::class
    ];

    protected $dispatchesEvents = [
        'created' => ApplicationCreated::class,
        'updated' => ApplicationUpdated::class,
        'deleted' => ApplicationDeleted::class
    ];

    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(Vacancy::class);
    }

    public function cv(): MorphOne
    {
        return $this->morphOne(Document::class, 'documentable');
    }
}
