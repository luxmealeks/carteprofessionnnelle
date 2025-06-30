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
    Schema::table('grades', function (Blueprint $table) {
        // Modifier la colonne nom pour accepter NULL ou avoir une valeur par défaut
        $table->string('nom')->nullable()->default('NON SPECIFIE')->change();
    });
}

public function down()
{
    Schema::table('grades', function (Blueprint $table) {
        $table->string('nom')->nullable(false)->change();
    });
}
};
