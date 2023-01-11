<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Actions\Contracts\CreateRolesActionInterface;
use Domain\Auth\DataTransferObjects\RoleData;
use Domain\Auth\Enums\Role;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Silber\Bouncer\BouncerFacade as Bouncer;

class CreateRolesAction implements CreateRolesActionInterface
{
    public function execute(): Collection
    {
        return collect(Role::cases())
            ->map(
                fn (Role $role) =>
                new RoleData(
                    name: $role->value,
                    title: Str::of($role->value)
                        ->ucfirst()
                        ->explode('-')
                        ->join(' ')
                )
            )->map(
                fn (RoleData $data) =>
                Bouncer::role()->firstOrCreate([
                    'name' => $data->name,
                    'title' => $data->title
                ])
            );
    }
}
