<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('lots', function (Blueprint $table) {
            $table->string('numero')->unique()->change();
        });
    }

    public function down()
    {
        Schema::table('lots', function (Blueprint $table) {
            $table->dropUnique(['numero']);
        });
    }

};
