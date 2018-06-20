<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class CheckoutRequest extends FormRequest
{
    private $types = ['credit card', 'boleto'];

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => ['required', 'regex:/^[^\d]{3,}$/'],
            'client_id' => 'required',
            'email' => 'required|email',
            'cpf' => 'required|cpf',
            'amount' => ['required','regex:/^[1-9]([\d]{1,})?$/'],
            'type' => ['required', Rule::in($this->types)]
        ];

        if($this->get('type') === 'credit card'){
            $rules += [
                'card_user' => ['required', 'regex:/^[^\d]{3,}$/'],
                'card_number' => 'required|ccn',
                'card_expiration_date' => 'required|ccd',
                'card_cvv' => 'required|cvc'
            ];
        }

      return $rules;
    }


    public function messages()
    {
        return [
            'name.regex' => ':attribute inválido.',
            'email' => 'E-mail invalido.',
            'type.in' => 'Por favor, informe o tipo de pagamento válido.',
            'cpf' => 'Por favor, informe um CPF válido.',
            'amount.regex' => 'attribute, formato inválido do total a ser pago.',
            'required' => 'O :attribute, deve ser informado.',
            'card_user.regex' => ':attribute, inválido',
            'ccd' => ':attribute, informe uma data válida.',
            'cvc' => ':attribute, senha do cartão invalida.',
            'ccn' => ':attribute, número do cartão inválido'
        ];
    }
}
