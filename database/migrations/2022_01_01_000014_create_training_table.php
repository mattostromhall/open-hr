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
        Schema::create('training', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->unsignedTinyInteger('status')->index();
            $table->unsignedTinyInteger('state')->index();
            $table->string('description');
            $table->string('provider');
            $table->text('location')->nullable();
            $table->unsignedBigInteger('cost')->nullable();
            $table->string('cost_currency')->nullable();
            $table->unsignedSmallInteger('duration')->nullable();
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainings');
    }
};
