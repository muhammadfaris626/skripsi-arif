<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'name'  => ['required', 'string', 'max:255', 'min:4'],
            'username' => ['required', 'string', Rule::unique('users', 'username')->ignore($this->id)],
            'email' => [
                'required','string', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($this->id),
            ],
            'password' => [
                Rule::excludeIf((!empty($this->id) && empty($this->password))),
                'required', 'min:8'
            ],
            'roles' => ['']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Kolom nama wajib diisi.',
            'username.required' => 'Kolom username wajib diisi.',
            'email.required' => 'Kolom email wajib diisi.',
            'password.required' => 'Kolom kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal :min karakter.'
        ];
    }
}
