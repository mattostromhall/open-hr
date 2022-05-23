<?php

namespace Domain\Absences\Models;

use Domain\Absences\Enums\HalfDay;
use Domain\Absences\Enums\HolidayStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Domain\People\Models\Person;
use Support\Concerns\Unguarded;

class Holiday extends Model
{
    use HasFactory;
    use Unguarded;

    protected $casts = [
        'status' => HolidayStatus::class,
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'half_day' => HalfDay::class,
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
