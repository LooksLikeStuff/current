<?php

namespace App\Http\Requests\Balance;

use Illuminate\Foundation\Http\FormRequest;

class UpRequest extends FormRequest
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
            'sum' => 'required|numeric|min:0.01',
        ];
    }

    public function messages()
    {
        return [
            'sum.required' => 'Введите сумму пополнения',
            'sum.min' => 'Сумма пополнения не может быть меньше 0.01',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'sum' => str_replace(',', '.', $this->sum),
        ]);
    }
}
