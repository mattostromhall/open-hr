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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->foreignId('manager_id')->nullable();
            $table->foreignId('department_id')->nullable();
            $table->string('title')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('initials')->nullable();
            $table->string('pronouns')->nullable();
            $table->date('dob');
            $table->string('position');
            $table->unsignedMediumInteger('remuneration');
            $table->enum('remuneration_interval', ['hourly', 'daily', 'weekly', 'monthly', 'yearly']);
            $table->string('remuneration_currency');
            $table->unsignedMediumInteger('base_holiday_allocation');
            $table->unsignedMediumInteger('holiday_carry_allocation')->default(0);
            $table->unsignedMediumInteger('holiday_carried')->default(0);
            $table->unsignedMediumInteger('sickness_allocation');
            $table->string('contact_number')->unique();
            $table->string('contact_email')->unique();
            $table->date('started_on');
            $table->date('finished_on')->nullable();

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
        Schema::dropIfExists('people');
    }
};
