<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RecycleRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'description' => ['required', 'string', 'max:1000'],
            'request_type' => ['required', Rule::in(['recycle', 'sell'])],
            'image' => ['nullable', 'image', 'max:4096'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'admin_price' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['pending', 'reviewing', 'approved', 'rejected', 'completed'])],
            'feedback' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
