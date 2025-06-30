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
        // 1. Assure que la colonne nom existe et est correcte
        Schema::table('grades', function (Blueprint $table) {
            $table->string('nom')->default('NON SPECIFIE')->change();
        });

        // 2. Met à jour les éventuels enregistrements vides
        DB::table('grades')->whereNull('nom')->update(['nom' => 'NON SPECIFIE']);

        // 3. Ajoute la contrainte NOT NULL
        Schema::table('grades', function (Blueprint $table) {
            $table->string('nom')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
