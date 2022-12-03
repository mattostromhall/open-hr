<?php

namespace App\Http\Notifications\Controllers;

use App\Http\Notifications\Requests\StoreNotificationRequest;
use App\Http\Notifications\ViewModels\OrganisationNotificationsViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Models\Notification;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class OrganisationNotificationController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Organisation/Notifications/Index', new OrganisationNotificationsViewModel());
    }

    /**
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize('organisationCreate', Notification::class);

        return Inertia::render('Organisation/Notifications/Create');
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreNotificationRequest $request, CreateNotificationAction $createNotification): RedirectResponse
    {
        $this->authorize('organisationCreate', Notification::class);

        $createNotification->execute($request->organisationNotificationData());

        return redirect(route('organisation.notifications'))
            ->with('flash.success', 'Organisation notification successfully created!');
    }
}
