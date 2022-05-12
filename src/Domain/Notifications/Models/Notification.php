<?php

namespace Domain\Notifications\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Support\Concerns\Unguarded;

class Notification extends Model
{
    use HasFactory;
    use Unguarded;

    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }
}
