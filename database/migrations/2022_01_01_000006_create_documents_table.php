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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('directory')->index();
            $table->unsignedBigInteger('size');
            $table->string('extension');
            $table->string('disk');
            $table->unsignedBigInteger('documentable_id');
            $table->string('documentable_type');
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['name', 'directory', 'extension']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
