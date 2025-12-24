<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WalletRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $walletId = $this->route('wallet')?->id;

        return [
            'user_id' => [
                'required',
                'exists:users,id',
                Rule::unique('wallets', 'user_id')->ignore($walletId),
            ],
            'balance' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'status' => ['required', Rule::in(['active', 'suspended'])],
        ];
    }
}
