<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCticShippingMethod extends Migration
{
    public function up()
    {
        Schema::table('shipping_methods', function (Blueprint $table) {
            $table->float('price')->nullable();
        });
    }

    public function down()
    {
        Schema::table('shipping_methods', function (Blueprint $table) {
            $table->dropColumn([
                'price',
            ]);
        });
    }
}
