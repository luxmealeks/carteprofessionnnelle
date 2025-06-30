<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('etablissements', function (Blueprint $table) {
            // Supprime la contrainte étrangère avant la colonne
            $table->dropForeign(['ia_id']);
            $table->dropColumn('ia_id');
        });
    }

    public function down(): void
    {
        Schema::table('etablissements', function (Blueprint $table) {
            $table->unsignedBigInteger('ia_id')->nullable()->after('id');
            $table->foreign('ia_id')->references('id')->on('inspection_academiques')->onDelete('set null');
        });
    }
};
