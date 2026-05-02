<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportCouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:csv,txt',
            'region_id' => 'required|exists:regions,id',
            'type' => 'required|in:pengkurban,umum',
        ];
    }
}
