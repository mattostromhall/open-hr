<?php

namespace Domain\Auth\Models;

use Domain\Auth\Collections\UserCollection;
use Domain\Auth\Events\UserCreated;
use Domain\Auth\Events\UserDeleted;
use Domain\Auth\Events\UserUpdated;
use Domain\Auth\QueryBuilders\UserQueryBuilder;
use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Support\Concerns\Reporting;
use Support\Concerns\Unguarded;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use Unguarded;
    use SoftDeletes;
    use HasRolesAndAbilities;
    use Reporting;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'active' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    protected $dispatchesEvents = [
        'created' => UserCreated::class,
        'updated' => UserUpdated::class,
        'deleted' => UserDeleted::class
    ];

    protected $with = ['person'];

    public static function query(): Builder|UserQueryBuilder
    {
        return parent::query();
    }

    public function newEloquentBuilder($query): UserQueryBuilder
    {
        return new UserQueryBuilder($query);
    }

    public function newCollection(array $models = []): UserCollection
    {
        return new UserCollection($models);
    }

    public function person(): HasOne
    {
        return $this->hasOne(Person::class);
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Hash::make($value)
        );
    }
}
