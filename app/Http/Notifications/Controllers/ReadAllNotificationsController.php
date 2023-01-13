<?php

namespace App\Http\Notifications\Controllers;

use App\Http\Notifications\Requests\ReadAllNotificationsRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Notifications\Actions\Contracts\ReadAllNotificationsActionInterface;
use Illuminate\Http\RedirectResponse;

class ReadAllNotificationsController extends Controller
{
    public function __invoke(
        ReadAllNotificationsRequest $request,
        ReadAllNotificationsActionInterface $updateNotification
    ): RedirectResponse {
        $updateNotification->execute($request->validated('notifiable_id'), $request->validated('notifiable_type'));

        return back();
    }
}
