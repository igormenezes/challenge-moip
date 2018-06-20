<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';
    public $timestamps = false;

    protected $fillable = [
    	'client_id', 
    	'name', 
    	'email', 
    	'cpf', 
    	'amount',
    	'type',
    	'status'
    ];

    public function ordersCreditCards()
    {
        return $this->hasOne('App\Models\CreditCards');
    }

    public function ordersBoletos()
    {
        return $this->hasOne('App\Models\Boletos');
    }
}
