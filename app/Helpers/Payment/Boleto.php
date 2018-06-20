<?php

namespace App\Helpers\Payment;

use App\Models\Boletos;

class Boleto implements PaymentInterface
{
	public function messages()
	{
		return [
			''
		];
	}

	public function rules()
	{
		return [
            ''
        ];
	}

	public function validate($request, $validator)
	{
        $result = $validator::make($request->all(), $this->rules(), $this->messages());

        if($result->fails()){
        	$arr = [];
			
			foreach ($result->errors()->all() as $message) {
				$arr[] = $message;
			}

        	return $arr;
        }
	}

	public function save($orders, $request)
	{	
		$numberBoleto = $this->generateBoleto();
		$boletos = new Boletos();
		$boletos->number = $numberBoleto;
        $orders->ordersBoletos()->save($boletos);

        return "Finalizado! Número do boleto gerado: {$numberBoleto}";
	}

	public function generateBoleto()
	{
		return rand(10000, 99999) . '.' . rand(10000, 99999) . ' ' . rand(10000, 99999) . '.' . rand(100000, 999999) . ' ' . rand(10000, 99999) . '.' . rand(100000, 999999) . ' ' . rand(1, 9) . ' ' . rand(10000000000000, 99999999999999);
	}
}