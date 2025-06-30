<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIefIdToEtablissementsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('etablissements', 'ief_id')) {
            Schema::table('etablissements', function (Blueprint $table) {
                $table->unsignedBigInteger('ief_id')->nullable()->after('inspection_academique_id');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('etablissements', 'ief_id')) {
            Schema::table('etablissements', function (Blueprint $table) {
                $table->dropColumn('ief_id');
            });
        }
    }
}
