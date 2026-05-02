<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'region_id' => 'required|exists:regions,id',
            'quantity' => 'required|integer|min:1|max:100',
            'type' => 'required|in:pengkurban,umum',
        ];
    }
}
