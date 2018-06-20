<?php

namespace App\Helpers\Payment;

interface PaymentInterface
{
	public function messages();
	public function rules();
	public function validate($request, $validator);
	public function save($orders, $request);
}