<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('prenom');
            $table->string('nom');
            $table->string('matricule')->unique();
            $table->string('cin')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('photo')->nullable();
            $table->enum('statut_photo', ['en_attente', 'validee', 'rejetee'])->default('en_attente');
            $table->text('motif_rejet_photo')->nullable();

            // Clés étrangères corrigées
            $table->unsignedBigInteger('etablissement_id')->nullable();
            $table->unsignedBigInteger('structure_id')->nullable(); // Notez que la table s'appelle 'structure'
            $table->unsignedBigInteger('inspection_academique_id')->nullable();
            $table->unsignedBigInteger('corps_id')->nullable();
            $table->unsignedBigInteger('grade_id')->nullable();
            $table->unsignedBigInteger('lot_id')->nullable();

            $table->timestamps();
        });

        // Ajout des contraintes séparément
        Schema::table('agents', function (Blueprint $table) {
            $table->foreign('etablissement_id')->references('id')->on('etablissements')->onDelete('set null');
            $table->foreign('structure_id')->references('id')->on('structure')->onDelete('set null'); // 'structure' sans 's'
            $table->foreign('inspection_academique_id')->references('id')->on('inspection_academiques')->onDelete('set null');
            $table->foreign('corps_id')->references('id')->on('corps')->onDelete('set null');
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('set null');
            $table->foreign('lot_id')->references('id')->on('lots')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->dropForeign(['etablissement_id']);
            $table->dropForeign(['structure_id']);
            $table->dropForeign(['inspection_academique_id']);
            $table->dropForeign(['corps_id']);
            $table->dropForeign(['grade_id']);
            $table->dropForeign(['lot_id']);
        });
        
        Schema::dropIfExists('agents');
    }
};