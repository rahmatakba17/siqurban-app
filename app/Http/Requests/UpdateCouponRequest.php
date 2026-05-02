<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'code' => 'required|string|max:255|unique:coupons,code,' . $this->coupon->id,
            'region_id' => 'required|exists:regions,id',
            'type' => 'required|in:pengkurban,umum',
            'sacrificer_name' => 'nullable|string|max:255',
            'special_request' => 'nullable|string',
            'status' => 'required|in:available,received,used',
        ];
    }
}
