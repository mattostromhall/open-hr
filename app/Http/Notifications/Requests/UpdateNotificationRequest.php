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

    public function validatedData(): array
    {
        return array_filter([
            'title' => $this->validated('title'),
            'body' => $this->validated('body'),
            'link' => $this->validated('link'),
            'read' => $this->validated('read'),
        ]);
    }
}
