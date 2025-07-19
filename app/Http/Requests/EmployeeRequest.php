<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'employee_number' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'effective_date' => ['required', 'string', 'max:255'],
            'position_id' => ['required', 'sometimes'],
            'rank_id' => ['required', 'sometimes'],
            'employee_status' => ['required', 'string', 'max:255'],
            'blood_group' => ['required', 'string', 'max:255'],
            'education_id' => ['required', 'max:255'],
        ];
    }

    public function messages(): array {
        return [
            'employee_number.required' => 'Kolom nomor pegawai wajib diisi.',
            'name.required' => 'Kolom nama wajib diisi.',
            'gender.required' => 'Kolom jenis kelamin wajib diisi.',
            'address.required' => 'Kolom alamat wajib diisi.',
            'phone.required' => 'Kolom nomor telepon wajib diisi.',
            'effective_date.required' => 'Kolom tanggal awal kerja wajib diisi.',
            'position_id.required' => 'Kolom jabatan wajib diisi.',
            'rank_id.required' => 'Kolom pangkat wajib diisi.',
            'employee_status.required' => 'Kolom status pegawai wajib diisi.',
            'blood_group.required' => 'Kolom golongan darah wajib diisi.',
            'education_id.required' => 'Kolom pendidikan terakhir wajib diisi.',
        ];
    }
}
