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
use Domain\Auth\Actions\AssignRoleAction;
use Domain\Auth\Actions\Contracts\AssignRoleActionInterface;
use Domain\Auth\Actions\Contracts\CreateAbilitiesActionInterface;
use Domain\Auth\Actions\Contracts\CreateRolesActionInterface;
use Domain\Auth\Actions\Contracts\CreateUserActionInterface;
use Domain\Auth\Actions\Contracts\DeleteUserActionInterface;
use Domain\Auth\Actions\Contracts\GiveAbilitiesToRolesActionInterface;
use Domain\Auth\Actions\Contracts\ResetPasswordActionInterface;
use Domain\Auth\Actions\Contracts\RetractRoleActionInterface;
use Domain\Auth\Actions\Contracts\SyncRolesActionInterface;
use Domain\Auth\Actions\Contracts\UpdateActiveActionInterface;
use Domain\Auth\Actions\Contracts\UpdateEmailActionInterface;
use Domain\Auth\Actions\Contracts\UpdatePasswordActionInterface;
use Domain\Auth\Actions\CreateAbilitiesAction;
use Domain\Auth\Actions\CreateRolesAction;
use Domain\Auth\Actions\CreateUserAction;
use Domain\Auth\Actions\DeleteUserAction;
use Domain\Auth\Actions\GiveAbilitiesToRolesAction;
use Domain\Auth\Actions\ResetPasswordAction;
use Domain\Auth\Actions\RetractRoleAction;
use Domain\Auth\Actions\SyncRolesAction;
use Domain\Auth\Actions\UpdateActiveAction;
use Domain\Auth\Actions\UpdateEmailAction;
use Domain\Auth\Actions\UpdatePasswordAction;
use Domain\Expenses\Actions\AmendExpenseAction;
use Domain\Expenses\Actions\Contracts\AmendExpenseActionInterface;
use Domain\Expenses\Actions\Contracts\CreateExpenseActionInterface;
use Domain\Expenses\Actions\Contracts\CreateExpenseTypeActionInterface;
use Domain\Expenses\Actions\Contracts\DeleteExpenseActionInterface;
use Domain\Expenses\Actions\Contracts\DeleteExpenseTypeActionInterface;
use Domain\Expenses\Actions\Contracts\RequestExpenseReviewActionInterface;
use Domain\Expenses\Actions\Contracts\ReviewExpenseActionInterface;
use Domain\Expenses\Actions\Contracts\SubmitExpenseActionInterface;
use Domain\Expenses\Actions\Contracts\UpdateExpenseActionInterface;
use Domain\Expenses\Actions\Contracts\UpdateExpenseTypeActionInterface;
use Domain\Expenses\Actions\Contracts\WithdrawExpenseActionInterface;
use Domain\Expenses\Actions\CreateExpenseAction;
use Domain\Expenses\Actions\CreateExpenseTypeAction;
use Domain\Expenses\Actions\DeleteExpenseAction;
use Domain\Expenses\Actions\DeleteExpenseTypeAction;
use Domain\Expenses\Actions\RequestExpenseReviewAction;
use Domain\Expenses\Actions\ReviewExpenseAction;
use Domain\Expenses\Actions\SubmitExpenseAction;
use Domain\Expenses\Actions\UpdateExpenseAction;
use Domain\Expenses\Actions\UpdateExpenseTypeAction;
use Domain\Expenses\Actions\WithdrawExpenseAction;
use Domain\Files\Actions\Contracts\CreateDefaultDocumentDirectoriesActionInterface;
use Domain\Files\Actions\Contracts\CreateDirectoryActionInterface;
use Domain\Files\Actions\Contracts\DeleteDirectoryActionInterface;
use Domain\Files\Actions\Contracts\DeleteDocumentActionInterface;
use Domain\Files\Actions\Contracts\DeleteDocumentsActionInterface;
use Domain\Files\Actions\Contracts\DeleteFileActionInterface;
use Domain\Files\Actions\Contracts\DocumentableDataFromDocumentPathActionInterface;
use Domain\Files\Actions\Contracts\DownloadDocumentActionInterface;
use Domain\Files\Actions\Contracts\StoreDocumentActionInterface;
use Domain\Files\Actions\Contracts\StoreFileActionInterface;
use Domain\Files\Actions\Contracts\UploadDocumentActionInterface;
use Domain\Files\Actions\Contracts\UploadDocumentsActionInterface;
use Domain\Files\Actions\CreateDefaultDocumentDirectoriesAction;
use Domain\Files\Actions\CreateDirectoryAction;
use Domain\Files\Actions\DeleteDirectoryAction;
use Domain\Files\Actions\DeleteDocumentAction;
use Domain\Files\Actions\DeleteDocumentsAction;
use Domain\Files\Actions\DeleteFileAction;
use Domain\Files\Actions\DocumentableDataFromDocumentPathAction;
use Domain\Files\Actions\DownloadDocumentAction;
use Domain\Files\Actions\StoreDocumentAction;
use Domain\Files\Actions\StoreFileAction;
use Domain\Files\Actions\UploadDocumentAction;
use Domain\Files\Actions\UploadDocumentsAction;
use Domain\Notifications\Actions\Contracts\CreateNotificationActionInterface;
use Domain\Notifications\Actions\Contracts\DeleteNotificationActionInterface;
use Domain\Notifications\Actions\Contracts\SendEmailNotificationActionInterface;
use Domain\Notifications\Actions\Contracts\UpdateNotificationActionInterface;
use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\Actions\DeleteNotificationAction;
use Domain\Notifications\Actions\SendEmailNotificationAction;
use Domain\Notifications\Actions\UpdateNotificationAction;
use Domain\Organisation\Actions\AmendDepartmentAction;
use Domain\Organisation\Actions\CompleteSetupAction;
use Domain\Organisation\Actions\Contracts\AmendDepartmentActionInterface;
use Domain\Organisation\Actions\Contracts\CompleteSetupActionInterface;
use Domain\Organisation\Actions\Contracts\CreateDepartmentActionInterface;
use Domain\Organisation\Actions\Contracts\CreateOrganisationActionInterface;
use Domain\Organisation\Actions\Contracts\DeleteDepartmentActionInterface;
use Domain\Organisation\Actions\Contracts\DissolveDepartmentActionInterface;
use Domain\Organisation\Actions\Contracts\ManageDepartmentMembersActionInterface;
use Domain\Organisation\Actions\Contracts\SetupDepartmentActionInterface;
use Domain\Organisation\Actions\Contracts\UpdateDepartmentActionInterface;
use Domain\Organisation\Actions\CreateDepartmentAction;
use Domain\Organisation\Actions\CreateOrganisationAction;
use Domain\Organisation\Actions\DeleteDepartmentAction;
use Domain\Organisation\Actions\DissolveDepartmentAction;
use Domain\Organisation\Actions\ManageDepartmentMembersAction;
use Domain\Organisation\Actions\SetupDepartmentAction;
use Domain\Organisation\Actions\UpdateDepartmentAction;
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

        // Auth Contracts
        $this->app->bind(AssignRoleActionInterface::class, AssignRoleAction::class);
        $this->app->bind(CreateAbilitiesActionInterface::class, CreateAbilitiesAction::class);
        $this->app->bind(CreateRolesActionInterface::class, CreateRolesAction::class);
        $this->app->bind(CreateUserActionInterface::class, CreateUserAction::class);
        $this->app->bind(DeleteUserActionInterface::class, DeleteUserAction::class);
        $this->app->bind(GiveAbilitiesToRolesActionInterface::class, GiveAbilitiesToRolesAction::class);
        $this->app->bind(ResetPasswordActionInterface::class, ResetPasswordAction::class);
        $this->app->bind(RetractRoleActionInterface::class, RetractRoleAction::class);
        $this->app->bind(SyncRolesActionInterface::class, SyncRolesAction::class);
        $this->app->bind(UpdateActiveActionInterface::class, UpdateActiveAction::class);
        $this->app->bind(UpdateEmailActionInterface::class, UpdateEmailAction::class);
        $this->app->bind(UpdatePasswordActionInterface::class, UpdatePasswordAction::class);

        // Expense Contracts
        $this->app->bind(AmendExpenseActionInterface::class, AmendExpenseAction::class);
        $this->app->bind(CreateExpenseActionInterface::class, CreateExpenseAction::class);
        $this->app->bind(CreateExpenseTypeActionInterface::class, CreateExpenseTypeAction::class);
        $this->app->bind(DeleteExpenseActionInterface::class, DeleteExpenseAction::class);
        $this->app->bind(DeleteExpenseTypeActionInterface::class, DeleteExpenseTypeAction::class);
        $this->app->bind(RequestExpenseReviewActionInterface::class, RequestExpenseReviewAction::class);
        $this->app->bind(ReviewExpenseActionInterface::class, ReviewExpenseAction::class);
        $this->app->bind(SubmitExpenseActionInterface::class, SubmitExpenseAction::class);
        $this->app->bind(UpdateExpenseActionInterface::class, UpdateExpenseAction::class);
        $this->app->bind(UpdateExpenseTypeActionInterface::class, UpdateExpenseTypeAction::class);
        $this->app->bind(WithdrawExpenseActionInterface::class, WithdrawExpenseAction::class);

        // File Contracts
        $this->app->bind(CreateDefaultDocumentDirectoriesActionInterface::class, CreateDefaultDocumentDirectoriesAction::class);
        $this->app->bind(CreateDirectoryActionInterface::class, CreateDirectoryAction::class);
        $this->app->bind(DeleteDirectoryActionInterface::class, DeleteDirectoryAction::class);
        $this->app->bind(DeleteDocumentActionInterface::class, DeleteDocumentAction::class);
        $this->app->bind(DeleteDocumentsActionInterface::class, DeleteDocumentsAction::class);
        $this->app->bind(DeleteFileActionInterface::class, DeleteFileAction::class);
        $this->app->bind(DocumentableDataFromDocumentPathActionInterface::class, DocumentableDataFromDocumentPathAction::class);
        $this->app->bind(DownloadDocumentActionInterface::class, DownloadDocumentAction::class);
        $this->app->bind(StoreDocumentActionInterface::class, StoreDocumentAction::class);
        $this->app->bind(StoreFileActionInterface::class, StoreFileAction::class);
        $this->app->bind(UploadDocumentActionInterface::class, UploadDocumentAction::class);
        $this->app->bind(UploadDocumentsActionInterface::class, UploadDocumentsAction::class);

        // Notification Contracts
        $this->app->bind(CreateNotificationActionInterface::class, CreateNotificationAction::class);
        $this->app->bind(DeleteNotificationActionInterface::class, DeleteNotificationAction::class);
        $this->app->bind(SendEmailNotificationActionInterface::class, SendEmailNotificationAction::class);
        $this->app->bind(UpdateNotificationActionInterface::class, UpdateNotificationAction::class);

        // Organisation Contracts
        $this->app->bind(AmendDepartmentActionInterface::class, AmendDepartmentAction::class);
        $this->app->bind(CompleteSetupActionInterface::class, CompleteSetupAction::class);
        $this->app->bind(CreateDepartmentActionInterface::class, CreateDepartmentAction::class);
        $this->app->bind(CreateOrganisationActionInterface::class, CreateOrganisationAction::class);
        $this->app->bind(DeleteDepartmentActionInterface::class, DeleteDepartmentAction::class);
        $this->app->bind(DissolveDepartmentActionInterface::class, DissolveDepartmentAction::class);
        $this->app->bind(ManageDepartmentMembersActionInterface::class, ManageDepartmentMembersAction::class);
        $this->app->bind(SetupDepartmentActionInterface::class, SetupDepartmentAction::class);
        $this->app->bind(UpdateDepartmentActionInterface::class, UpdateDepartmentAction::class);
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
