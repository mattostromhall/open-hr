<?php

namespace Domain\Recruitment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Domain\Files\Models\Document;
use Support\Concerns\Unguarded;

class Vacancy extends Model
{
    use HasFactory;
    use Unguarded;

    protected $casts = [
        'open_at' => 'date',
        'close_at' => 'date',
    ];

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
