<?php

namespace App\Http\Notifications\Requests;

use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ReadAllNotificationsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'notifiable_id' => ['required', 'numeric'],
            'notifiable_type' => ['required', new Enum(NotifiableType::class)]
        ];
    }
}
