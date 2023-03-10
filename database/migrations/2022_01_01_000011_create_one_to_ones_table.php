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
        Schema::create('one_to_ones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('manager_id')->constrained('people');
            $table->foreignId('requester_id')->constrained('people');
            $table->unsignedTinyInteger('person_status')->index();
            $table->unsignedTinyInteger('manager_status')->index();
            $table->dateTime('scheduled_at');
            $table->dateTime('completed_at')->nullable();
            $table->boolean('recurring')->default(false);
            $table->string('recurrence_interval')->default('never');
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
        Schema::dropIfExists('one_to_ones');
    }
};
