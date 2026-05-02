<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|max:255|unique:coupons,code',
            'region_id' => 'required|exists:regions,id',
            'type' => 'required|in:pengkurban,umum',
            'sacrificer_name' => 'nullable|string|max:255',
            'special_request' => 'nullable|string',
            'status' => 'required|in:available,received,used',
        ];
    }
}
