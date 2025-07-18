<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('inspection_academiques', function (Blueprint $table) {
            $table->string('code')->unique()->nullable()->after('nom');
        });
    }

    public function down(): void
    {
        Schema::table('inspection_academiques', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
};
