<?php

namespace App\Http\Notifications\Controllers;

use App\Http\Support\Controllers\Controller;
use Domain\Notifications\Actions\Contracts\DeleteNotificationActionInterface;
use Domain\Notifications\Models\Notification;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;

class NotificationController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function destroy(Notification $notification, DeleteNotificationActionInterface $deleteNotification): RedirectResponse
    {
        $this->authorize('delete', $notification);

        $deleted = $deleteNotification->execute($notification);

        if (! $deleted) {
            return back()->with('flash.error', 'There was a problem with deleting the notification, please try again.');
        }

        return back()->with('flash.success', 'Notification deleted!');
    }
}
