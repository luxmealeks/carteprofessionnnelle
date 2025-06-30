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
        $table->timestamp('date_generation')->nullable()->after('updated_at');
    });
}

public function down()
{
    Schema::table('lots', function (Blueprint $table) {
        $table->dropColumn('date_generation');
    });
}
};
