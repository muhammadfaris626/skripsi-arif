<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApprovalSettingRequest extends FormRequest
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
            'certificate_category_id' => ['required'],
            'position_id' => ['required'],
            'step' => ['required'],
            'approver_1' => [],
            'approver_2' => [],
            'approver_3' => [],
            'approver_4' => [],
            'approver_5' => []
        ];
    }

    public function messages(): array {
        return [
            'certificate_category_id.required' => 'Kolom kategori surat wajib diisi.',
            'position_id.required' => 'Kolom jabatan wajib diisi.',
            'step.required' => 'Kolom jumlah persetujuan wajib diisi.',
        ];
    }
}
