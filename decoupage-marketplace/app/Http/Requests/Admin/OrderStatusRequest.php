<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(['pending', 'processing', 'completed', 'cancelled'])],
            'payment_status' => ['required', Rule::in(['pending', 'paid', 'refunded'])],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
