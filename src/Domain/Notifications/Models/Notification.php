<?php

namespace Domain\Notifications\Models;

use Domain\Notifications\Enums\NotifiableType;
use Domain\Notifications\Events\NotificationCreated;
use Domain\Notifications\Events\NotificationUpdated;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Support\Casts\HTML;
use Support\Concerns\Unguarded;

class Notification extends Model
{
    use HasFactory;
    use Unguarded;
    use Prunable;

    protected $casts = [
        'body' => HTML::class,
        'read' => 'boolean',
        'notifiable_type' => NotifiableType::class
    ];

    protected $dispatchesEvents = [
        'created' => NotificationCreated::class,
        'updated' => NotificationUpdated::class
    ];

    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    public function prunable(): Builder
    {
        return self::query()
            ->where('read', true)
            ->whereNot('notifiable_type', 'organisation')
            ->where('created_at', '<=', now()->subMonth());
    }
}
