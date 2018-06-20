<?php

namespace App\Helpers\Payment;

use App\Models\CreditCards;

class CreditCard implements PaymentInterface 
{
	public function messages()
	{
		return [
			'required' => 'O :attribute, deve ser informado.',
			'card_user.regex' => ':attribute, inválido',
			'ccd' => ':attribute, informe uma data válida.',
			'cvc' => ':attribute, senha do cartão invalida.',
			'ccn' => ':attribute, número do cartão inválido'
		];
	}

	public function rules()
	{
		return [
            'card_user' => ['required', 'regex:/^[^\d]{3,}$/'],
          	'card_number' => 'required|ccn',
          	'card_expiration_date' => 'required|ccd',
          	'card_cvv' => 'required|cvc'
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
		$creditcards = new CreditCards();
		$creditcards->card_user = $request->card_user;
        $creditcards->card_number = $request->card_number;
        $creditcards->card_expiration_date = $this->formatDate($request->card_expiration_date);
        $creditcards->card_cvv = $request->card_cvv;
        $creditcards->card_issuer = $this->getCardIssuer($request->card_number);
        $orders->ordersCreditCards()->save($creditcards);

        //Payment Credit Card Aproved
        $orders::where('id', $orders->id)->update(['status' => 'success']);

        return 'Pagamento realizado com sucesso!';
	}

	public function getCardIssuer($cardNumber)
	{
		$cardNumber = str_replace(' ', '', $cardNumber);

		$visaFirstLetters = ['4'];
		$mastercardFirstLetters = ['5'];
		$dinersFirstLetters = ['301', '305', '36', '38'];
		$eloFirtsLetters = [
			'636368', '438935', '504175', '451416', '509048', '509067', 
			'509049','509069','509050', '509074', '509068', '509040','509045', '509051', 
			'509046', '509066', '509047', '509042', '509052', '509043', '509064', '509040', '36297', '5067', '4576', '4011'
		];
		$amexFirstLetters = ['34', '37'];
		$discoverFirstLetters = ['6011', '622', '64', '65'];
		$auraFirstLetters = ['50'];
		$jcbFirstLetters = ['35'];
		$hipercardFirstLetters = ['38', '60'];

		//dd(substr($cardNumber, 0, 4));

		if(in_array(substr($cardNumber, 0, 6), $eloFirtsLetters) ||
			in_array(substr($cardNumber, 0, 5), $eloFirtsLetters) || 
			in_array(substr($cardNumber, 0, 4), $eloFirtsLetters)){
			return 'Elo';
		}elseif(in_array(substr($cardNumber, 0, 4), $discoverFirstLetters) || 
			in_array(substr($cardNumber, 0, 3), $discoverFirstLetters) || 
			in_array(substr($cardNumber, 0, 2), $discoverFirstLetters)){
			return 'Discover';
		}elseif(in_array(substr($cardNumber, 0, 3), $dinersFirstLetters) || 
			in_array(substr($cardNumber, 0, 2), $dinersFirstLetters)){
			return 'Diners';
		}elseif(in_array(substr($cardNumber, 0, 2), $amexFirstLetters)){
			return 'Amex';
		}elseif(in_array(substr($cardNumber, 0, 2), $auraFirstLetters)){
			return 'Aura';
		}elseif(in_array(substr($cardNumber, 0, 2), $jcbFirstLetters)){
			return 'JCB';
		}elseif(in_array(substr($cardNumber, 0, 2), $hipercardFirstLetters)){
			return 'Hipercard';
		}elseif(in_array(substr($cardNumber, 0, 1), $visaFirstLetters)){
			return 'Visa';
		}elseif(in_array(substr($cardNumber, 0, 1), $mastercardFirstLetters)){
			return 'Mastercard';
		}

		return 'Não encontrado';
	}

	public function formatDate($date)
	{
		$arr = explode('/', $date);

		$dia = date("t", mktime(0,0,0,$arr[0],'01',$arr[1]));

		return "{$arr[1]}-{$arr[0]}-{$dia}";
	}
}