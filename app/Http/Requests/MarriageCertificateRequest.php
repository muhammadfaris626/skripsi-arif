<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarriageCertificateRequest extends FormRequest
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
            'request_number' => [''],
            'user_id' => [''],
            'name' => ['required'],
            'place_of_birth' => ['required'],
            'date_of_birth' => ['required'],
            'work_id' => ['required'],
            'couple_name' => ['required'],
            'partner_address' => ['required'],
            'guardian_name' => ['required'],
            'wedding_date' => ['required'],
            'name_of_the_chief' => ['required'],
            'bride_price' => ['required'],
            'witness_name' => ['required'],
        ];
    }

    public function messages(): array {
        return [
            // 'marriage_request_number' => '',
            // 'user_id' => '',
            'name.required' => 'Kolom nama wajib diisi.',
            'place_of_birth.required' => 'Kolom tempat lahir wajib diisi.',
            'date_of_birth.required' => 'Kolom tanggal lahir wajib diisi.',
            'work_id.required' => 'Kolom pekerjaan wajib diisi.',
            'couple_name.required' => 'Kolom nama pasangan wajib diisi.',
            'partner_address.required' => 'Kolom alamat pasangan wajib diisi',
            'guardian_name.required' => 'Kolom nama wali wajib diisi.',
            'wedding_date.required' => 'Kolom tanggal menikah wajib diisi.',
            'name_of_the_chief.required' => 'Kolom nama penghulu wajib diisi.',
            'bride_price.required' => 'Kolom mahar wajib diisi.',
            'witness_name.required' => 'Kolom nama saksi wajib diisi.'
        ];
    }
}
