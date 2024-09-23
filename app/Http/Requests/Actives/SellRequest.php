<?php

namespace App\Http\Requests\Actives;

use App\Rules\Balance\AvailableQuantity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SellRequest extends FormRequest
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
            'ticker_id' => 'required|integer|exists:tickers,id',
            'quantity' => ['required', 'integer', 'min:1', new AvailableQuantity($this->ticker_id)],
        ];
    }

    public function messages()
    {
        return [
            'ticker_id.required' => 'Необходимо выбрать тикер',
            'ticker_id.exists' => 'Выбранный тикер не существует',
            'quantity.required' => 'Необходимо ввести количество',
            'quantity.integer' => 'Количество должно быть целым числом',
        ];
    }
}
