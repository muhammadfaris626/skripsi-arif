<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessCertificateRequest extends FormRequest
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
            'cover_letter_id'     => ['required'],
            'request_number'      => [''],
            'user_id'             => [''],
            'resident_id'         => [''],
            'name'                => ['required'],
            'resident_number'     => ['required'],
            'place_of_birth'      => ['required'],
            'date_of_birth'       => ['required'],
            'religion'            => ['required'],
            'gender'              => ['required'],
            'work_id'             => ['required'],
            'address'             => ['required'],
            'business_name'       => ['required'],
            'business_address'    => ['required'],
            'long_term'           => ['required'],
            'validity_period'     => [''],
            'description'         => ['required'],
        ];
    }

    public function messages(): array {
        return [
            'cover_letter_id.required'     => 'Kolom surat pengantar wajib diisi.',
            'name.required'                => 'Kolom nama wajib diisi.',
            'resident_number.required'     => 'Kolom nomor induk kependudukan wajib diisi.',
            'place_of_birth.required'      => 'Kolom tempat lahir wajib diisi.',
            'date_of_birth.required'       => 'Kolom tanggal lahir wajib diisi.',
            'religion.required'            => 'Kolom agama wajib diisi.',
            'gender.required'              => 'Kolom jenis kelamin wajib diisi.',
            'work_id.required'             => 'Kolom pekerjaan wajib diisi.',
            'address.required'             => 'Kolom alamat wajib diisi.',
            'business_name.required'       => 'Kolom nama usaha wajib diisi.',
            'business_address.required'    => 'Kolom alamat usaha wajib diisi.',
            'long_term.required'           => 'Kolom lama usaha wajib diisi.',
            'description.required'         => 'Kolom alasan buat usaha wajib diisi.'
        ];
    }
}
