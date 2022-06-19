<?php

namespace App\Http\Notifications\Controllers;

use App\Http\Support\Controllers\Controller;
use Domain\Notifications\Actions\ReadNotificationAction;
use Domain\Notifications\Models\Notification;
use Illuminate\Http\RedirectResponse;

class ReadNotificationController extends Controller
{
    public function __invoke(
        Notification $notification,
        ReadNotificationAction $readNotification
    ): RedirectResponse {
        $readNotification->execute($notification);

        return back();
    }
}
