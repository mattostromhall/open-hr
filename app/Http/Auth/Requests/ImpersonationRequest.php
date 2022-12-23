<?php

namespace App\Http\Auth\Requests;

use Domain\Auth\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ImpersonationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['sometimes', 'required', Rule::in(User::query()->get()->pluck('id'))]
        ];
    }

    public function impersonate()
    {
        $this->session()->put('impersonator', $this->user()->id);

        auth()->loginUsingId($this->validated('id'));
    }

    public function cancel()
    {
        $impersonator = $this->session()->pull('impersonator');

        auth()->loginUsingId($impersonator);
    }
}
