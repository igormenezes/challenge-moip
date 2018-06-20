<?php

namespace App\Facades;

use App\Helpers\Payment\PaymentInterface;
use App\Helpers\Payment\Boleto;
use App\Helpers\Payment\CreditCard;

use Illuminate\Validation\Rule;

class Payment
{
	private static $_payment;
	private static $types = ['credit card', 'boleto'];

	public static function messages()
	{
		return [
			'required' => 'O :attribute deve ser informado.',
			'name.regex' => ':attribute inválido.',
			'email' => 'E-mail invalido.',
			'type.in' => 'Por favor, informe o tipo de pagamento válido.',
			'cpf' => 'Por favor, informe um CPF válido.',
			'amount.regex' => 'attribute, formato inválido do total a ser pago.'
		];
	}

	public static function rules()
	{
		return [
            'name' => ['required', 'regex:/^[^\d]{3,}$/'],
            'client_id' => 'required',
            'email' => 'required|email',
            'cpf' => 'required|cpf',
            'amount' => ['required','regex:/^[1-9]([\d]{1,})?$/'],
            'type' => ['required', Rule::in(self::$types)]
        ];
	}

	public static function validate($request, $validator)
	{
		$result = $validator::make($request->all(), self::rules(), self::messages());

        if($result->fails()){
        	$failure = [];
			
			foreach ($result->errors()->all() as $message) {
				$failure[] = $message;
			}

        	return $failure;
        }

		if($request->type === 'credit card'){
			self::$_payment = new CreditCard();
		} else if($request->type === 'boleto'){
			self::$_payment = new Boleto();
		}

		$failure = self::$_payment->validate($request, $validator);

		return $failure;
	}

	public static function save($orders, $request)
	{	
		return self::$_payment->save($orders, $request);
	}

	public static function formatAmount($amount)
	{
		return 'R$' . number_format($amount, 2, ',', '.');
	}
}