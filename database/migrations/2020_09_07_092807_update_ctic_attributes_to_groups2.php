<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCticAttributesToGroups2 extends Migration
{
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->integer('product_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropColumn([
                'product_id',
            ]);
        });
    }
}
