<?php

namespace App\Providers;

use Domain\Absences\Actions\AmendHolidayAction;
use Domain\Absences\Actions\AmendSicknessAction;
use Domain\Absences\Actions\CancelHolidayAction;
use Domain\Absences\Actions\CancelSicknessAction;
use Domain\Absences\Actions\Contracts\AmendHolidayActionInterface;
use Domain\Absences\Actions\Contracts\AmendSicknessActionInterface;
use Domain\Absences\Actions\Contracts\CancelHolidayActionInterface;
use Domain\Absences\Actions\Contracts\CancelSicknessActionInterface;
use Domain\Absences\Actions\Contracts\CreateHolidayActionInterface;
use Domain\Absences\Actions\Contracts\CreateSicknessActionInterface;
use Domain\Absences\Actions\Contracts\DeleteHolidayActionInterface;
use Domain\Absences\Actions\Contracts\DeleteSicknessActionInterface;
use Domain\Absences\Actions\Contracts\LogSicknessActionInterface;
use Domain\Absences\Actions\Contracts\RequestHolidayActionInterface;
use Domain\Absences\Actions\Contracts\RequestHolidayReviewActionInterface;
use Domain\Absences\Actions\Contracts\ReviewHolidayActionInterface;
use Domain\Absences\Actions\Contracts\UpdateHolidayActionInterface;
use Domain\Absences\Actions\Contracts\UpdateSicknessActionInterface;
use Domain\Absences\Actions\CreateHolidayAction;
use Domain\Absences\Actions\CreateSicknessAction;
use Domain\Absences\Actions\DeleteHolidayAction;
use Domain\Absences\Actions\DeleteSicknessAction;
use Domain\Absences\Actions\LogSicknessAction;
use Domain\Absences\Actions\RequestHolidayAction;
use Domain\Absences\Actions\RequestHolidayReviewAction;
use Domain\Absences\Actions\ReviewHolidayAction;
use Domain\Absences\Actions\UpdateHolidayAction;
use Domain\Absences\Actions\UpdateSicknessAction;
use Illuminate\Support\ServiceProvider;
use Support\Contracts\Services\ReportBuilderInterface;
use Support\Services\ReportBuilder;

class OpenHRServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(ReportBuilderInterface::class, ReportBuilder::class);
        // Absence Contracts
        $this->app->bind(AmendHolidayActionInterface::class, AmendHolidayAction::class);
        $this->app->bind(AmendSicknessActionInterface::class, AmendSicknessAction::class);
        $this->app->bind(CancelHolidayActionInterface::class, CancelHolidayAction::class);
        $this->app->bind(CancelSicknessActionInterface::class, CancelSicknessAction::class);
        $this->app->bind(CreateHolidayActionInterface::class, CreateHolidayAction::class);
        $this->app->bind(CreateSicknessActionInterface::class, CreateSicknessAction::class);
        $this->app->bind(DeleteHolidayActionInterface::class, DeleteHolidayAction::class);
        $this->app->bind(DeleteSicknessActionInterface::class, DeleteSicknessAction::class);
        $this->app->bind(LogSicknessActionInterface::class, LogSicknessAction::class);
        $this->app->bind(RequestHolidayActionInterface::class, RequestHolidayAction::class);
        $this->app->bind(RequestHolidayReviewActionInterface::class, RequestHolidayReviewAction::class);
        $this->app->bind(ReviewHolidayActionInterface::class, ReviewHolidayAction::class);
        $this->app->bind(UpdateHolidayActionInterface::class, UpdateHolidayAction::class);
        $this->app->bind(UpdateSicknessActionInterface::class, UpdateSicknessAction::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
