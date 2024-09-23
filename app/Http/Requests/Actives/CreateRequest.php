<?php

namespace App\Http\Requests\Actives;

use App\Rules\EnoughBalance;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0.01',
            'commission' => 'required|numeric',
            'balance' => ['required', new EnoughBalance($this->quantity, $this->price, $this->commission)],
        ];
    }

    public function messages()
    {
        return [
            'ticker_id.required' => 'Необходимо выбрать тикер',
            'ticker_id.exists' => 'Выбранный тикер не существует',
            'quantity.required' => 'Введите количество акций',
            'date.required' => 'Необходимо выбрать дату',
            'date,date' => 'Некорректный формат даты',
            'quantity.integer' => 'Количество должно быть целым числом',
            'price.required' => 'Введите цену',
            'price.min' => 'Цена не может быть меньше 0.01',
            'commission.required' => 'Введите комиссию',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'balance' => auth()->user()->balance('RUB')->value->get(),
            'price' => str_replace(',', '.', $this->price),
            'commission' => str_replace(',', '.', $this->commission),
        ]);
    }
}
