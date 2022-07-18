<?php

namespace App\Http\Notifications\Requests;

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

    public function validatedData(): array
    {
        return [
            'title' => $this->validated('title'),
            'body' => $this->validated('body'),
            'link' => $this->validated('link')
        ];
    }
}
