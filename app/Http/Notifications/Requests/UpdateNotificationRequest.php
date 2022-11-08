<?php

namespace App\Http\Notifications\Requests;

use Domain\Notifications\DataTransferObjects\NotificationData;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['string', 'max:255'],
            'body' => ['string'],
            'link' => ['string', 'max:255'],
            'read' => ['boolean']
        ];
    }

    public function notificationData(): NotificationData
    {
        return NotificationData::from([
            ...$this->notification->toArray(),
            ...$this->safe()->all()
        ]);
    }
}
