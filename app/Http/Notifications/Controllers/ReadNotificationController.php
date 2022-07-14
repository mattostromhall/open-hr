<?php

namespace App\Http\Notifications\Controllers;

use App\Http\Notifications\Requests\UpdateNotificationRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Notifications\Actions\UpdateNotificationAction;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Models\Notification;
use Illuminate\Http\RedirectResponse;

class ReadNotificationController extends Controller
{
    public function __invoke(
        UpdateNotificationRequest $request,
        Notification $notification,
        UpdateNotificationAction $updateNotification
    ): RedirectResponse {
        $updateNotification->execute(
            $notification,
            new NotificationData(
                body: $notification->body,
                notifiable_id: $notification->notifiable_id,
                notifiable_type: $notification->notifiable_type,
                title: $notification->title,
                link: $notification->link,
                read: $request->validated('read')
            )
        );

        return back();
    }
}
