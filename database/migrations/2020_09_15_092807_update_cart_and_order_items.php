<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCartAndOrderItems extends Migration
{
    public function up()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->integer('parent_id')->nullable();
            $table->integer('group_id')->nullable();
            $table->float('cost')->nullable();
            $table->float('iva')->nullable();
            $table->float('iva_price')->nullable();
            $table->float('line_price')->nullable();
            $table->string('note')->nullable();
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->integer('parent_id')->nullable();
            $table->integer('group_id')->nullable();
            $table->float('cost')->nullable();
            $table->float('iva')->nullable();
            $table->float('iva_price')->nullable();
            $table->float('line_price')->nullable();
            $table->string('note')->nullable();
        });
    }

    public function down()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropColumn([
                'parent_id',
                'group_id',
                'cost',
                'iva',
                'iva_price',
                'line_price',
                'note',
            ]);
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn([
                'parent_id',
                'group_id',
                'cost',
                'iva',
                'iva_price',
                'line_price',
                'note',
            ]);
        });
    }
}
