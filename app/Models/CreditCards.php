<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditCards extends Model
{
	protected $table = 'credit_cards';
    public $timestamps = false;

    protected $fillable = [
    	'orders_id', 
    	'card_user', 
    	'card_number', 
    	'card_expiration_date', 
    	'card_cvv', 
    	'card_issuer'
    ];

    public function creditCards()
    {
        return $this->belongsTo('App\Models\Orders');
    }

    public function setDatas($orders, $request, $cardIssuer)
    {
        $this->card_user = $request->card_user;
        $this->card_number = $request->card_number;
        $this->card_expiration_date = $request->card_expiration_date;
        $this->card_cvv = $request->card_cvv;
        $this->card_issuer = $cardIssuer;
        $orders->ordersCreditCards()->save($this);
    }
}
