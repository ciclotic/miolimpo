<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCticOrderParameters extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->bigInteger('payment_method_id')->nullable();
            $table->bigInteger('shipping_method_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method_id',
                'shipping_method_id',
            ]);
        });
    }
}
