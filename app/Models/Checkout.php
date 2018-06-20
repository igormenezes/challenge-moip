<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected $table = 'checkout';
    public $timestamps = false;

    protected $fillable = [
    	'id',
    	'name',
    	'email',
    	'cpf',
    	'amount',
    	'type', 
    	'card_user', 
    	'card_number', 
    	'card_expiration_date', 
    	'card_cvv', 
    	'card_issuer'
    ];
}
