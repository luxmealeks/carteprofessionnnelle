<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasTable('agent_lot')) {
            Schema::create('agent_lot', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('lot_id');
                $table->unsignedBigInteger('agent_id');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('agent_lot');
    }
};
