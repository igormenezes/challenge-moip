<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCheckout extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkout', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('email', 100);
            $table->char('cpf', 14);
            $table->string('amount', 100);
            $table->enum('type', ['credit card', 'boleto']);
            $table->string('card_user', 100)->nullable();
            $table->char('card_number', 19)->nullable();
            $table->date('card_expiration_date')->nullable();
            $table->char('card_cvv', 3)->nullable();
            $table->string('card_issuer', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkout');
    }
}
