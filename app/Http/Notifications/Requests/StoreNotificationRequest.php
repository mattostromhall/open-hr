<?php

namespace App\Http\Notifications\Requests;

use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;
use Illuminate\Foundation\Http\FormRequest;

class StoreNotificationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['string', 'max:255'],
            'body' => ['required', 'string'],
            'link' => ['string', 'max:255']
        ];
    }

    public function organisationNotificationData(): NotificationData
    {
        return NotificationData::from([
            'notifiable_id' => organisation()->id,
            'notifiable_type' => NotifiableType::ORGANISATION,
            ...$this->safe()->all()
        ]);
    }
}
