<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCticAttributesToGroups extends Migration
{
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->dropColumn([
                'created_at',
                'updated_at',
            ]);
        });
    }
}
