<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')
                ->constrained();
            $table->string('action');
            $table->text('payload');
            $table->unsignedBigInteger('actionable_id');
            $table->string('actionable_type');
            $table->timestamps();

            $table->index(['actionable_type', 'actionable_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('action_logs');
    }
};
