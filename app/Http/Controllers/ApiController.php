<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

use App\Facades\Payment;
use App\Models\Orders;

class ApiController extends Controller
{
	private $_validator;
	private $_request;
	private $_orders;

	public function __construct(Validator $validator, Request $request, Orders $orders)
	{
		$this->_validator = $validator;
		$this->_request = $request;
		$this->_orders = $orders;
	}

	public function save()
	{	
		try{
			$payment = new Payment();
			$failure = $payment->validate($this->_request, $this->_validator);

			if(empty($failure)){
				$this->_orders->client_id = $this->_request->client_id;
				$this->_orders->name = $this->_request->name;	
				$this->_orders->email = $this->_request->email;
				$this->_orders->cpf = $this->_request->cpf;
				$this->_orders->amount = $payment->formatAmount($this->_request->amount);
				$this->_orders->type = $this->_request->type;
				$this->_orders->save();

				$message = $payment->save($this->_orders, $this->_request);

				return response()->json(['success' => true, 'message' => $message], 200);
			}

			return response()->json(['success' => false, 'errors' => $failure], 400);

		}catch(\Exception $e){
			return response()->json([
					'success' => false, 
					'errors' => 'Ocorreu um erro ao processar o pagamento!'
				], 400);;
		}
	}

    public function get()
    {
    	$result = $this->_orders::with('ordersCreditCards', 'ordersBoletos')->where('client_id', $this->_request->client_id)
	    	->where('id', $this->_request->id)
	    	->first();

	    if(!empty($result)){
	    	return response()->json([
	    		'success' => true,
	    		'status' => $result->status, 
	    		'type' => $result->type,
	    		'numero_boleto' => !empty($result->ordersBoletos) ? $result->ordersBoletos->number : null,
	    		'numero_cartao' => !empty($result->ordersCreditCards) ? $result->ordersCreditCards->card_number : null
	    	], 200);	
	    }

	    return response()->json(['success' => false, 'errors' => 'Nenhum pedido encontrado!'], 400);
    }
}