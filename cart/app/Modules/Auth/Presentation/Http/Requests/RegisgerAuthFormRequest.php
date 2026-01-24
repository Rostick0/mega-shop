<?php

namespace App\Modules\Auth\Presentation\Http\Requests;

use App\Modules\User\Infrastructure\Eloquent\UserModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RegisgerAuthFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'       => ['sometimes', 'nullable', 'string', 'max:255'],
            'email'      => ['required', 'string', 'email', 'min:1', 'max:100', Rule::unique(UserModel::class, 'email')],
            'password'   => ['required', 'nullable', 'string', 'min:8', 'max:30'],
        ];
    }
}
