<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckoutTest extends TestCase
{
	public function setUp()
	{
        parent::setUp();
		\DB::beginTransaction();
    }

    public function testCheckoutWithCreditCardSuccess()
    {
    	$response = $this->json('POST', '/save', [
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

    public function testCheckoutSuccess()
    {
    	$response = $this->json('POST', '/save', [
    		'client_id' => '348298791817d5088a6de6',
            'type' => 'boleto',
            'name' => 'João Francisco',
            'cpf' => '022.051.300-72',
            'email' => 'teste@gmail.com',
            'amount' => '150000'
        ]);

	    $response->assertStatus(200);
    }

    public function testCheckoutFail()
    {
    	$response = $this->json('POST', '/save', [
    		'client_id' => '',
            'type' => 'boleto',
            'name' => 'João Francisco',
            'cpf' => '022.051.300-72',
            'email' => 'teste@gmail.com',
            'amount' => '150000'
        ]);

	    $response->assertStatus(422);
    }

    public function testCheckoutWithCreditCardFail()
    {
    	$response = $this->json('POST', '/save', [
    		'client_id' => '348298791817d5088a6de6',
            'type' => 'credit card',
            'name' => 'João Francisco',
            'cpf' => '022.051.300-72',
            'email' => 'teste@gmail.com',
            'amount' => '150000',
            'card_user' => '',
            'card_number' => '',
            'card_expiration_date' => '',
            'card_cvv' => ''
        ]);

	    $response->assertStatus(422);
    }

    public function tearDown()
    {
		\DB::rollback();
	}
}
