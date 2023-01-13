<?php

namespace App\Http\Notifications\Controllers;

use App\Http\Notifications\Requests\ReadAllNotificationsRequest;
use App\Http\Support\Controllers\Controller;
use Domain\Notifications\Actions\Contracts\ReadAllNotificationsActionInterface;
use Domain\Notifications\Enums\NotifiableType;
use Illuminate\Http\RedirectResponse;

class ReadAllNotificationsController extends Controller
{
    public function __invoke(ReadAllNotificationsRequest $request, ReadAllNotificationsActionInterface $readNotifications): RedirectResponse
    {
        $readNotifications->execute(
            $request->validated('notifiable_id'),
            NotifiableType::from($request->validated('notifiable_type'))
        );

        return back()->with('flash.success', 'All Notifications marked as read!');
    }
}
