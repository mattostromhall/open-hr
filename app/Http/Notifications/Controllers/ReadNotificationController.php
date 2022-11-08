<?php

namespace App\Http\Notifications\Controllers;

use App\Http\Notifications\Requests\UpdateNotificationRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Notifications\Actions\UpdateNotificationAction;
use Domain\Notifications\Models\Notification;
use Illuminate\Http\RedirectResponse;

class ReadNotificationController extends Controller
{
    public function __invoke(
        UpdateNotificationRequest $request,
        Notification $notification,
        UpdateNotificationAction $updateNotification
    ): RedirectResponse {
        $updateNotification->execute($notification, $request->notificationData());

        return back();
    }
}
