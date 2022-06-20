<?php

namespace App\Http\Notifications\Requests;

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


}
