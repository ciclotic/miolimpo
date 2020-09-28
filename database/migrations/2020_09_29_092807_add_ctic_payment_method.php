<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCticPaymentMethod extends Migration
{
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('observation')->nullable();
            $table->string('gateway')->nullable();
            $table->string('order')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('payment_methods');
    }
}
