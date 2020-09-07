<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCticAttributesToProducts extends Migration
{
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('observation')->nullable();
            $table->string('order')->nullable();
            $table->boolean('mandatory')->nullable();
            $table->boolean('unique_group')->nullable();
            $table->boolean('collapsed')->nullable();
        });

        Schema::create('product_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('group_id');
            $table->string('order')->nullable();
            $table->decimal('price', 15, 4)->nullable();
            $table->boolean('group_modifiable')->nullable();
        });

        Schema::create('complement_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('main_product_id');
            $table->integer('complement_product_id');
            $table->tinyInteger('selected')->nullable();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->string('barcode')->nullable();
            $table->string('order')->nullable();
            $table->text('observation')->nullable();
            $table->decimal('cost', 15, 4)->nullable();
            $table->decimal('price_2', 15, 4)->nullable();
            $table->decimal('price_3', 15, 4)->nullable();
            $table->decimal('price_4', 15, 4)->nullable();
            $table->decimal('price_5', 15, 4)->nullable();
            $table->decimal('iva', 7, 2)->nullable();
            $table->boolean('manage_stock')->nullable();
            $table->string('send')->nullable();
            $table->tinyInteger('archetype')->nullable();
        });
    }

    public function down()
    {
        Schema::drop('groups');
        Schema::drop('product_groups');
        Schema::drop('complement_products');
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'barcode',
                'order',
                'observation',
                'cost',
                'price_2',
                'price_3',
                'price_4',
                'price_5',
                'iva',
                'manage_stock',
                'send',
                'archetype'
            ]);
        });
    }
}
