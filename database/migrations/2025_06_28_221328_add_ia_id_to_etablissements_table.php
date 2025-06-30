<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   /**
     * Run the migrations (suppression).
     */
    public function up()
{
    // Vérifiez d'abord si la colonne existe déjà
    if (!Schema::hasColumn('etablissements', 'ia_id')) {
        Schema::table('etablissements', function (Blueprint $table) {
            $table->foreignId('ia_id')->nullable()->after('id')
                  ->constrained('inspection_academiques');
        });
    }
}

public function down()
{
    // Vérifiez que la colonne existe avant de la supprimer
    if (Schema::hasColumn('etablissements', 'ia_id')) {
        Schema::table('etablissements', function (Blueprint $table) {
            $table->dropForeign(['ia_id']);
            $table->dropColumn('ia_id');
        });
    }
}
};
