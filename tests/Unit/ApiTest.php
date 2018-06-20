<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Helpers\Payment\CreditCard;
use App\Helpers\Payment\Boleto;
use App\Models\Orders;
use App\Models\CreditCards;
use App\Models\Boletos;

class ApiTest extends TestCase
{
	private $_modelOrders;
	private $_modelCreditCards;
	private $_modelBoletos;

	private $_helperCreditCard;
	private $_helperBoleto;

	public function setUp()
	{
        parent::setUp();

        $this->_modelOrders = new Orders();
        $this->_modelCreditCards = new CreditCards();
        $this->_modelBoletos = new Boletos();

        $this->_helperCreditCard = new CreditCard();
        $this->_helperBoleto = new Boleto();

		\DB::beginTransaction();
    }

    public function testPostCreditCardSuccess()
    {
    	$response = $this->json('POST', '/api/save', [
    		'client_id' => '348298791817d5088a6de6',
            'type' => 'credit card',
            'name' => 'João Francisco',
            'cpf' => '022.051.300-72',
            'email' => 'teste@gmail.com',
            'amount' => '150000',
            'card_user' => 'João Francisco',
            'card_number' => '4514 1671 3283 6410',
            'card_expiration_date' => '12/2018',
            'card_cvv' => '111'
        ]);

	    $response->assertStatus(200);
    }

    public function testPostCreditCardClientIdInvalid()
    {
    	$response = $this->json('POST', '/api/save', [
    		'client_id' => '',
            'type' => 'credit card',
            'name' => 'João Francisco',
            'cpf' => '022.051.300-72',
            'email' => 'teste@gmail.com',
            'amount' => '15000',
            'card_user' => 'João Francisco',
            'card_number' => '4514 1671 3283 6410',
            'card_expiration_date' => '12/2018',
            'card_cvv' => '111'
        ]);

	    $response->assertStatus(400);
    }

    public function testPostCreditCardTypeInvalid()
    {
    	$response = $this->json('POST', '/api/save', [
    		'client_id' => '348298791817d5088a6de6',
            'type' => 'pagamento',
            'name' => 'João Francisco',
            'cpf' => '022.051.300-72',
            'email' => 'teste@gmail.com',
            'amount' => '15000',
            'card_user' => 'João Francisco',
            'card_number' => '4514 1671 3283 6410',
            'card_expiration_date' => '12/2018',
            'card_cvv' => '111'
        ]);

	    $response->assertStatus(400);
    }

   	public function testPostCreditCardNameInvalid()
    {
    	$response = $this->json('POST', '/api/save', [
    		'client_id' => '348298791817d5088a6de6',
            'type' => 'credit card',
            'name' => '',
            'cpf' => '022.051.300-72',
            'email' => 'teste@gmail.com',
            'amount' => '15000',
            'card_user' => 'João Francisco',
            'card_number' => '4514 1671 3283 6410',
            'card_expiration_date' => '12/2018',
            'card_cvv' => '111'
        ]);

	    $response->assertStatus(400);
    }

    public function testPostCreditCardCPFInvalid()
    {
    	$response = $this->json('POST', '/api/save', [
    		'client_id' => '348298791817d5088a6de6',
            'type' => 'pagamento',
            'name' => 'João Francisco',
            'cpf' => '111.111.111-22',
            'email' => 'teste@gmail.com',
            'amount' => 'R$ 150,00',
            'card_user' => 'João Francisco',
            'card_number' => '4514 1671 3283 6410',
            'card_expiration_date' => '12/2018',
            'card_cvv' => '111'
        ]);

	    $response->assertStatus(400);
    }

    public function testPostCreditEmailInvalid()
    {
    	$response = $this->json('POST', '/api/save', [
    		'client_id' => '348298791817d5088a6de6',
            'type' => 'credit card',
            'name' => 'João Francisco',
            'cpf' => '022.051.300-72',
            'email' => 'igormenezes',
            'amount' => '15000',
            'card_user' => 'João Francisco',
            'card_number' => '4514 1671 3283 6410',
            'card_expiration_date' => '12/2018',
            'card_cvv' => '111'
        ]);

	    $response->assertStatus(400);
    }

   	public function testPostCreditAmountInvalid()
    {
    	$response = $this->json('POST', '/api/save', [
    		'client_id' => '348298791817d5088a6de6',
            'type' => 'credit card',
            'name' => 'João Francisco',
            'cpf' => '022.051.300-72',
            'email' => 'teste@gmail.com',
            'amount' => '000',
            'card_user' => 'João Francisco',
            'card_number' => '4514 1671 3283 6410',
            'card_expiration_date' => '12/2018',
            'card_cvv' => '111'
        ]);

	    $response->assertStatus(400);
    }

    public function testPostCreditCardUserInvalid()
    {
    	$response = $this->json('POST', '/api/save', [
    		'client_id' => '348298791817d5088a6de6',
            'type' => 'credit card',
            'name' => 'João Francisco',
            'cpf' => '022.051.300-72',
            'email' => 'teste@gmail.com',
            'amount' => '150000',
            'card_user' => '11',
            'card_number' => '4514 1671 3283 6410',
            'card_expiration_date' => '12/2018',
            'card_cvv' => '111'
        ]);

	    $response->assertStatus(400);
    }

    public function testPostCreditCardNumberInvalid()
    {
    	$response = $this->json('POST', '/api/save', [
    		'client_id' => '348298791817d5088a6de6',
            'type' => 'credit card',
            'name' => 'João Francisco',
            'cpf' => '022.051.300-72',
            'email' => 'teste@gmail.com',
            'amount' => '150000',
            'card_user' => 'João Francisco',
            'card_number' => '1111 1111 1111 1111',
            'card_expiration_date' => '12/2018',
            'card_cvv' => '111'
        ]);

	    $response->assertStatus(400);
    }

    public function testPostCreditCardExpirationDateInvalid()
    {
    	$response = $this->json('POST', '/api/save', [
    		'client_id' => '348298791817d5088a6de6',
            'type' => 'credit card',
            'name' => 'João Francisco',
            'cpf' => '022.051.300-72',
            'email' => 'teste@gmail.com',
            'amount' => '150000',
            'card_user' => 'João Francisco',
            'card_number' => '4514 1671 3283 6410',
            'card_expiration_date' => '11/1111',
            'card_cvv' => '111'
        ]);

	    $response->assertStatus(400);
    }

    public function testPostCreditCardCVVInvalid()
    {
    	$response = $this->json('POST', '/api/save', [
    		'client_id' => '348298791817d5088a6de6',
            'type' => 'credit card',
            'name' => 'João Francisco',
            'cpf' => '022.051.300-72',
            'email' => 'teste@gmail.com',
            'amount' => '150000',
            'card_user' => 'João Francisco',
            'card_number' => '4514 1671 3283 6410',
            'card_expiration_date' => '12/2018',
            'card_cvv' => 'aaa'
        ]);

	    $response->assertStatus(400);
    }

    public function testVerifyCardIssuerSuccess()
    {
    	$response = $this->_helperCreditCard->getCardIssuer('5141 2063 0316 8076');
    	$this->assertEquals('Mastercard', $response);

    	$response = $this->_helperCreditCard->getCardIssuer('4532 9247 5195 2482');
    	$this->assertEquals('Visa', $response);

    	$response = $this->_helperCreditCard->getCardIssuer('3756 134356 02013');
    	$this->assertEquals('Amex', $response);

    	$response = $this->_helperCreditCard->getCardIssuer('3808 601698 4879');
    	$this->assertEquals('Diners', $response);    	

    	$response = $this->_helperCreditCard->getCardIssuer('6011 7669 5674 1797');
    	$this->assertEquals('Discover', $response);

    	$response = $this->_helperCreditCard->getCardIssuer('3505 2301 4817 7253');
    	$this->assertEquals('JCB', $response);

    	$response = $this->_helperCreditCard->getCardIssuer('5041 7567 0084 4498');
    	$this->assertEquals('Elo', $response);
    }

    public function testGetOrderCreditCardSuccess()
    {
        $this->_modelOrders->client_id = '348298791817d5088a6de6';
		$this->_modelOrders->name = 'João Francisco';	
		$this->_modelOrders->email = 'teste@gmail.com';
		$this->_modelOrders->cpf = '022.051.300-72';
		$this->_modelOrders->amount = 'R$ 150,00';
		$this->_modelOrders->type = 'credit card';
		$this->_modelOrders->save();

		$this->_modelCreditCards->card_user = 'João Francisco';
		$this->_modelCreditCards->card_number = '4514 1671 3283 6410';
		$this->_modelCreditCards->card_expiration_date = $this->_helperCreditCard->formatDate('12/2018');
		$this->_modelCreditCards->card_cvv = '111';
		$this->_modelCreditCards->card_issuer = $this->_helperCreditCard->getCardIssuer('514 1671 3283 6410');
        $this->_modelOrders->ordersCreditCards()->save($this->_modelCreditCards);


        $response = $this->json('GET', '/api/get', [
    		'client_id' => '348298791817d5088a6de6',
    		'id' => $this->_modelOrders->id
        ]);

        $response->assertStatus(200);
    }

    public function testGetOrderCreditCardFail()
    {
        $this->_modelOrders->client_id = '348298791817d5088a6de6';
		$this->_modelOrders->name = 'João Francisco';	
		$this->_modelOrders->email = 'teste@gmail.com';
		$this->_modelOrders->cpf = '022.051.300-72';
		$this->_modelOrders->amount = 'R$ 150,00';
		$this->_modelOrders->type = 'credit card';
		$this->_modelOrders->save();

		$this->_modelCreditCards->card_user = 'João Francisco';
		$this->_modelCreditCards->card_number = '4514 1671 3283 6410';
		$this->_modelCreditCards->card_expiration_date = $this->_helperCreditCard->formatDate('12/2018');
		$this->_modelCreditCards->card_cvv = '111';
		$this->_modelCreditCards->card_issuer = $this->_helperCreditCard->getCardIssuer('514 1671 3283 6410');
        $this->_modelOrders->ordersCreditCards()->save($this->_modelCreditCards);


        $response = $this->json('GET', '/api/get', [
    		'client_id' => '1817d5088a6de6',
    		'id' => $this->_modelOrders->id
        ]);

        $response->assertStatus(400);
    }

    public function testGetOrderBoletoSuccess()
    {
        $this->_modelOrders->client_id = '348298791817d5088a6de6';
		$this->_modelOrders->name = 'João Francisco';	
		$this->_modelOrders->email = 'teste@gmail.com';
		$this->_modelOrders->cpf = '022.051.300-72';
		$this->_modelOrders->amount = 'R$ 150,00';
		$this->_modelOrders->type = 'credit card';
		$this->_modelOrders->save();

		$this->_modelBoletos->number = $this->_helperBoleto->generateBoleto();
        $this->_modelOrders->ordersCreditCards()->save($this->_modelBoletos);

        $response = $this->json('GET', '/api/get', [
    		'client_id' => '348298791817d5088a6de6',
    		'id' => $this->_modelOrders->id
        ]);

        $response->assertStatus(200);
    }

    public function testGetOrderBoletoFail()
    {
        $this->_modelOrders->client_id = '348298791817d5088a6de6';
		$this->_modelOrders->name = 'João Francisco';	
		$this->_modelOrders->email = 'teste@gmail.com';
		$this->_modelOrders->cpf = '022.051.300-72';
		$this->_modelOrders->amount = 'R$ 150,00';
		$this->_modelOrders->type = 'credit card';
		$this->_modelOrders->save();

		$this->_modelBoletos->number = $this->_helperBoleto->generateBoleto();
        $this->_modelOrders->ordersCreditCards()->save($this->_modelBoletos);

        $response = $this->json('GET', '/api/get', [
    		'client_id' => '1817d5088a6de6',
    		'id' => $this->_modelOrders->id
        ]);

        $response->assertStatus(400);
    }

    public function tearDown()
    {
		\DB::rollback();
	}
}