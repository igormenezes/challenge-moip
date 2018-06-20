<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boletos extends Model
{
	protected $table = 'boletos';
    public $timestamps = false;

    protected $fillable = ['orders_id', 'number', 'active'];

    public function boletos()
    {
        return $this->belongsTo('App\Models\Orders');
    }

    public function setDatas($orders, $numberBoleto)
    {
        $this->number = $numberBoleto;
        $orders->ordersBoletos()->save($this);
    }
}
