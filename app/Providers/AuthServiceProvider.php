<?php

namespace App\Providers;

use Domain\Auth\Policies\RolePolicy;
use Domain\Files\Policies\DirectoryPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Silber\Bouncer\Database\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
         Role::class => RolePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('create-directory', [DirectoryPolicy::class, 'create']);
        Gate::define('delete-directory', [DirectoryPolicy::class, 'delete']);

        Gate::guessPolicyNamesUsing(function ($modelClass) {
            $module = Str::betweenFirst($modelClass, 'Domain\\', '\\');
            $model = Str::after($modelClass, 'Models\\');

            return "Domain\\{$module}\Policies\\{$model}Policy";
        });
    }
}
