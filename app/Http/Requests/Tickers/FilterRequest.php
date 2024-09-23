<?php

namespace App\Http\Requests\Tickers;

use App\Http\Services\DateService;
use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->flash();

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
            'date' =>"required|date",
        ];
    }

    public function prepareForValidation()
    {
        if (!$this->date) $this->merge(['date' => DateService::now()->toDateString()]);
    }
}
