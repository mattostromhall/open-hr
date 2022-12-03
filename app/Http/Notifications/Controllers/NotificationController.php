<?php

namespace App\Http\Notifications\Controllers;

use App\Http\Notifications\Requests\StoreNotificationRequest;
use App\Http\Notifications\ViewModels\OrganisationNotificationsViewModel;
use App\Http\Support\Controllers\Controller;
use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\Actions\DeleteNotificationAction;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Models\Notification;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class NotificationController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function destroy(Notification $notification, DeleteNotificationAction $deleteNotification): RedirectResponse
    {
        $this->authorize('delete', $notification);

        $deleted = $deleteNotification->execute($notification);

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem with deleting the notification, please try again.');
        }

        return back()->with('flash.success', 'Notification deleted!');
    }
}
