<?php

namespace Domain\Organisation\Models;

use Domain\Files\Models\Document;
use Domain\Notifications\Models\Notification;
use Domain\Organisation\Events\OrganisationDeleted;
use Domain\Organisation\Events\OrganisationUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Support\Concerns\Unguarded;

class Organisation extends Model
{
    use HasFactory;
    use Unguarded;

    protected $table = 'organisation';

    protected $casts = [
        'setup_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'updated' => OrganisationUpdated::class,
        'deleted' => OrganisationDeleted::class
    ];

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
