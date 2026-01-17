<?php

namespace App\Modules\Order\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreOrderListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => [Rule::requiredIf(fn() => !Auth::check()), 'email']
            // 'page'       => ['sometimes', 'integer', 'min:1'],
            // 'limit'      => ['sometimes', 'integer', 'min:1', 'max:100'],
            // 'title'      => ['sometimes', 'nullable', 'string', 'max:255'],
            // 'price_from' => ['sometimes', 'nullable', 'numeric'],
            // 'price_to'   => ['sometimes', 'nullable', 'numeric'],
        ];
    }
}
