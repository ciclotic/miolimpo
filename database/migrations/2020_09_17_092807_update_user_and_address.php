<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserAndAddress extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('newsletter')->nullable();
            $table->string('surname')->nullable();
            $table->string('phone')->nullable();
        });
        Schema::create('address_books', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->string('addressee_name');
            $table->string('addressee_surname')->nullable();
            $table->string('address');
            $table->string('address2')->nullable();
            $table->string('postal_code');
            $table->string('town');
            $table->string('phone')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'newsletter',
                'surname',
                'phone',
            ]);
        });
        Schema::drop('address_books');
    }
}
