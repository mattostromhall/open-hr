<?php

namespace App\Providers;

use Domain\Auth\Policies\RolePolicy;
use Domain\Files\Policies\DirectoryPolicy;
use Domain\Performance\Policies\PerformancePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Silber\Bouncer\Database\Role;
use Support\Models\ActionLog;
use Support\Models\Report;
use Support\Policies\ActionLogPolicy;
use Support\Policies\ReportPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        ActionLog::class => ActionLogPolicy::class,
        Report::class => ReportPolicy::class,
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
        Gate::define('manage-performance', [PerformancePolicy::class, 'manage']);

        Gate::guessPolicyNamesUsing(function ($modelClass) {
            $module = Str::betweenFirst($modelClass, 'Domain\\', '\\');
            $model = Str::after($modelClass, 'Models\\');

            return "Domain\\{$module}\Policies\\{$model}Policy";
        });
    }
}
