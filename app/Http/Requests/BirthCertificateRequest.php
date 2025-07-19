<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BirthCertificateRequest extends FormRequest
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
            'name' => ['required'],
            'gender' => ['required'],
            'religion' => ['required'],
            'place_of_birth' => ['required'],
            'date_of_birth' => ['required'],
            'time_of_birth' => ['required'],
            'family_card_id' => ['required'],
            'father_name' => ['required'],
            'mother_name' => ['required'],
            'address' => ['required'],
            'child_from' => ['required'],
            'give_birth_in' => ['required'],
            'birth_location' => ['required'],
            'weight' => ['required'],
            'birth_certificate' => ['required'],
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'Kolom nama wajib diisi.',
            'gender.required' => 'Kolom jenis kelamin wajib diisi.',
            'religion.required' => 'Kolom agama wajib diisi.',
            'place_of_birth.required' => 'Kolom tempat lahir wajib diisi.',
            'date_of_birth.required' => 'Kolom tanggal lahir wajib diisi.',
            'time_of_birth.required' => 'Kolom waktu kelahiran wajib diisi.',
            'family_card_id.required' => 'Kolom nomor KK wajib diisi.',
            'father_name.required' => 'Kolom nama ayah wajib diisi.',
            'mother_name.required' => 'Kolom nama ibu wajib diisi.',
            'address.required' => 'Kolom alamat wajib diisi.',
            'child_from.required' => 'Kolom anak ke wajib diisi.',
            'give_birth_in.required' => 'Kolom melahirkan di wajib diisi.',
            'birth_location.required' => 'Kolom lokasi melahirkan wajib diisi.',
            'weight.required' => 'Kolom berat badan wajib diisi.',
            'birth_certificate.required' => 'Kolom surat kelahiran wajib diisi.',
        ];
    }
}
