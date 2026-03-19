<?php

namespace App\Modules\Cart\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_id'      => ['required', 'integer', 'min:1'],
            'title_snapshot'  => ['required', 'string', 'max:255'],
            'price_snapshot'  => ['required', 'numeric', 'min:0'],
            'quantity'        => ['required', 'integer', 'min:1'],
        ];
    }
}
