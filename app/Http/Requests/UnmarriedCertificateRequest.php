<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnmarriedCertificateRequest extends FormRequest
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
            'cover_letter_id' => ['required'],
            'request_number'  => [''],
            'user_id'         => [''],
            'resident_id'     => [''],
            'name'            => ['required'],
            'resident_number' => ['required'],
            'place_of_birth'  => ['required'],
            'date_of_birth'   => ['required'],
            'gender'          => ['required'],
            'marital_status'  => ['required'],
            'religion'        => ['required'],
            'work_id'         => ['required'],
            'address'         => ['required'],
            'description'     => ['required']
        ];
    }

    public function messages(): array {
        return [
            'cover_letter_id.required' => 'Kolom surat pengantar wajib diisi.',
            'name.required'            => 'Kolom nama wajib diisi.',
            'resident_number.required' => 'Kolom nomor induk kependudukan wajib diisi.',
            'place_of_birth.required'  => 'Kolom tempat lahir wajib diisi.',
            'date_of_birth.required'   => 'Kolom tanggal lahir wajib diisi.',
            'gender.required'          => 'Kolom jenis kelamin wajib diisi.',
            'marital_status.required'  => 'Kolom status perkawinan wajib diisi.',
            'religion.required'        => 'Kolom agama wajib diisi.',
            'work_id.required'         => 'Kolom pekerjaan wajib diisi.',
            'address.required'         => 'Kolom alamat wajib diisi.',
            'description.required'     => 'Kolom alasan buat surat wajib diisi.'
        ];
    }
}
