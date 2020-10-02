<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Update2CticShippingMethod extends Migration
{
    public function up()
    {
        Schema::table('shipping_methods', function (Blueprint $table) {
            $table->dateTime('last_sale_at')->nullable();
            $table->integer('units_sold')->nullable();
        });
    }

    public function down()
    {
        Schema::table('shipping_methods', function (Blueprint $table) {
            $table->dropColumn([
                'units_sold',
                'last_sale_at',
            ]);
        });
    }
}
