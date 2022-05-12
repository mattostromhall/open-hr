<?php

namespace Domain\HR\Models;

use Domain\Notifications\Models\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Shared\Models\User;
use Support\Concerns\Unguarded;

class HR extends Model
{
    use HasFactory;
    use Unguarded;

    protected $table = 'hr';

    public function notifications(): MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
