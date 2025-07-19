<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoverLetterRequest extends FormRequest
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
            'resident_id'             => [],
            'name'                    => ['required'],
            'place_of_birth'          => ['required'],
            'date_of_birth'           => ['required'],
            'gender'                  => ['required'],
            'religion'                => ['required'],
            'work_id'                 => ['required'],
            'address'                 => ['required'],
            'resident_number'         => ['required'],
            'family_number'           => ['required'],
            'certificate_category_id' => ['required'],
        ];
    }

    public function messages(): array {
        return [
            'name.required'                    => 'Kolom nama wajib diisi.',
            'place_of_birth.required'          => 'Kolom tempat lahir wajib diisi.',
            'date_of_birth.required'           => 'Kolom tanggal lahir wajib diisi.',
            'gender.required'                  => 'Kolom jenis kelamin wajib diisi.',
            'religion.required'                => 'Kolom agama wajib diisi.',
            'work_id.required'                 => 'Kolom pekerjaan wajib diisi.',
            'address.required'                 => 'Kolom address wajib diisi.',
            'resident_number.required'         => 'Kolom nomor induk kependudukan wajib diisi.',
            'family_number.required'           => 'Kolom nomor kartu keluarga wajib diisi.',
            'certificate_category_id.required' => 'Kolom jenis surat wajib diisi.',
        ];
    }
}
