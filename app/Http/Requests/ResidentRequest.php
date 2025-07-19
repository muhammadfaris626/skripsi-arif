<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResidentRequest extends FormRequest
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
            'family_card_id' => ['required'],
            'resident_name' => ['required'],
            'resident_number' => ['required'],
            'gender' => ['required'],
            'place_of_birth' => ['required'],
            'date_of_birth' => ['required'],
            'religion' => ['required'],
            'education_id' => ['required'],
            'work_id' => ['required'],
            'blood_group' => ['required'],
            'marital_status' => ['required'],
            'wedding_date' => [],
            'relationship_status' => ['required'],
            'citizenship' => ['required'],
            'paspor_number' => [],
            'kitap_number' => [],
            'father_name' => ['required'],
            'mother_name' => ['required'],
            'phone_number' => ['required'],
        ];
    }

    public function messages(): array {
        return [
            'family_card_id.required' => 'Kolom kartu keluarga wajib diisi.',
            'resident_name.required' => 'Kolom nama penduduk wajib diisi.',
            'resident_number.required' => 'Kolom nomor penduduk wajib diisi.',
            'gender.required' => 'Kolom jenis kelamin wajib diisi.',
            'place_of_birth.required' => 'Kolom tempat lahir wajib diisi.',
            'date_of_birth.required' => 'Kolom tanggal lahir wajib diisi.',
            'religion.required' => 'Kolom agama wajib diisi.',
            'education_id.required' => 'Kolom pendidikan terakhir wajib diisi.',
            'work_id.required' => 'Kolom pekerjaan wajib diisi.',
            'blood_group.required' => 'Kolom golongan darah wajib diisi.',
            'marital_status.required' => 'Kolom status pernikahan wajib diisi.',
            'relationship_status.required' => 'Kolom status hubungan dalam keluarga wajib diisi.',
            'citizenship.required' => 'Kolom kewarganegaraan wajib diisi.',
            'father_name.required' => 'Kolom nama ayah wajib diisi.',
            'mother_name.required' => 'Kolom nama ibu wajib diisi.',
            'phone_number.required' => 'Kolom nomor telepon wajib diisi.',
        ];
    }
}
