<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FamilyCardRequest extends FormRequest
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
            'family_number' => ['required', 'string'],
            'name' => ['required', 'string'],
            'address' => ['required'],
            'rt' => ['required'],
            'rw' => ['required'],
            'province_id' => ['required'],
            'regency_id' => ['required'],
            'district_id' => ['required'],
            'village_id' => ['required'],
            'postal_code' => ['required'],
        ];
    }

    public function messages(): array {
        return [
            'family_number.required' => 'Kolom nomor kartu keluarga wajib diisi.',
            'name.required' => 'Kolom nama kepala keluarga wajib diisi.',
            'address.required' => 'Kolom alamat wajib diisi.',
            'rt.required' => 'Kolom RT wajib diisi.',
            'rw.required' => 'Kolom RW wajib diisi.',
            'province_id.required' => 'Kolom provinsi wajib diisi.',
            'regency_id.required' => 'Kolom kota / kabupaten wajib diisi.',
            'district_id.required' => 'Kolom kecamatan wajib diisi.',
            'village_id.required' => 'Kolom kelurahan wajib diisi.',
            'postal_code.required' => 'Kolom kode pos wajib diisi.',
        ];
    }
}
