<?php

namespace Domain\People\Models;

use Domain\People\Events\AddressCreated;
use Domain\People\Events\AddressDeleted;
use Domain\People\Events\AddressUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Support\Concerns\Reporting;
use Support\Concerns\Unguarded;

class Address extends Model
{
    use HasFactory;
    use Unguarded;
    use SoftDeletes;
    use Reporting;

    protected $dispatchesEvents = [
        'created' => AddressCreated::class,
        'updated' => AddressUpdated::class,
        'deleted' => AddressDeleted::class
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
