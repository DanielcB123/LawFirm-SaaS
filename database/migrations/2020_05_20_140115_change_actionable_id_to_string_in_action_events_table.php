<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::getConnection()->getDriverName() === 'sqlite' || ! Schema::hasTable('action_events')) {
            return;
        }

        Schema::table('action_events', function (Blueprint $table) {
            $table->string('actionable_id')->change();
            $table->string('target_id')->change();
            $table->string('model_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::getConnection()->getDriverName() === 'sqlite' || ! Schema::hasTable('action_events')) {
            return;
        }

        Schema::table('action_events', function (Blueprint $table) {
            $table->unsignedBigInteger('actionable_id')->change();
            $table->unsignedBigInteger('target_id')->change();
            $table->unsignedBigInteger('model_id')->change();
        });
    }
};
