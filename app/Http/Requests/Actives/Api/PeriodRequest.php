<?php

namespace App\Http\Requests\Actives\Api;

use App\Rules\Period;
use Illuminate\Foundation\Http\FormRequest;

class PeriodRequest extends FormRequest
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
//        return [
//            'period' => ['required', new Period],
//            'amount' => ['required', 'integer', 'min:1', 'max:365'],
//        ];

        return [
            'periods' => [
                'json' => [
                    'period' => ['required', new Period()],
                    'amount' => ['required', 'integer', 'min:1', 'max:365'],
                ],
            ],
        ];
    }

    public function prepareForValidation(): void
    {

//        if (is_int($this->amount)) {
//            if ($this->amount < 0) $this->merge(['amount' => 1]);
//
//            if ($this->amount > 365) $this->merge(['amount' => 365]);
//        }
//
//        $this->merge([
//            'period' => mb_strtoupper($this->period),
//        ]);
    }

}
