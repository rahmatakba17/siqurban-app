<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'app_name' => 'required|string|max:255',
            'app_url' => 'required|url|max:255',
            'masjid_name' => 'required|string|max:255',
            'tahun_kurban' => 'required|digits:4',
        ];
    }
}
