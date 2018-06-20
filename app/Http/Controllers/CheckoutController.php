<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Route;

use App\Http\Requests\CheckoutRequest;
use App\Models\Checkout;
use App\Helpers\Payment\CreditCard;

class CheckoutController extends Controller
{
    public function index()
    {
    	return view('checkout');
    }

    public function save(CheckoutRequest $request, Checkout $checkout, CreditCard $creditCard)
    {
    	try{
    		$checkout::create([
    			'name' => $request->name,
    			'email' => $request->email,
    			'cpf' => $request->cpf,
    			'amount' => 'R$' . number_format($request->amount, 2, ',', '.'),
    			'type' => $request->type,
    			'card_user' => !empty($request->card_user) ? $request->card_user : null,
    			'card_number' => !empty($request->card_number) ? $request->card_number : null,
    			'card_expiration_date' => !empty($request->card_expiration_date) ? $creditCard->formatDate($request->card_expiration_date) : null,
    			'card_cvv' => !empty($request->card_cvv) ? $request->card_cvv : null,
    			'card_issuer' => !empty($request->card_number) ? $creditCard->getCardIssuer($request->card_number) : null
    		]);

    		$request = Request::create('/api/save', 'POST', [
    			'name' => $request->name,
    			'email' => $request->email,
    			'cpf' => $request->cpf,
    			'amount' => $request->amount,
    			'type' => $request->type,
    			'card_user' => $request->card_user,
    			'card_number' => $request->card_number,
    			'card_expiration_date' => $request->card_expiration_date,
    			'card_cvv' => $request->card_cvv
    		]);

    		$response = json_decode(\Route::dispatch($request)->getContent());

    		if($response->success){
    			return view('checkout', ['success' => $response->message]);	
    		}

    		return view('checkout', ['fail' => $response->message]);	
    		
    	}catch(\Exception $e){
    		return view('checkout', ['fail' => 'Ocorreu um erro ao salvar os dados!']);
    	}
    }
}
