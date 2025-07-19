<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VillageRequest extends FormRequest
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
            'district_id' => ['required'],
            'name' => ['required']
        ];
    }

    public function messages(): array {
        return [
            'district_id.required' => 'Kolom kecamatan wajib diisi.',
            'name.required' => 'Kolom nama kelurahan wajib diisi.'
        ];
    }
}
