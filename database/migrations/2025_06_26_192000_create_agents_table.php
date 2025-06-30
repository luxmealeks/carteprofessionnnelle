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
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('prenom');
            $table->string('nom');
            $table->string('matricule')->unique();
            $table->string('cin')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('photo')->nullable(); // chemin de la photo
            $table->enum('statut_photo', ['en_attente', 'validee', 'rejetee'])->default('en_attente');
            $table->text('motif_rejet_photo')->nullable();

            // ✅ CORRECTIONS ici
            $table->foreignId('etablissement_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('direction_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('inspection_academique_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('corps_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('grade_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('lot_id')->nullable()->constrained()->onDelete('set null');

            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
