<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tower1_id')->nullable()->references('id')->on('towers');
            $table->foreignId('tower2_id')->nullable()->references('id')->on('towers');
            $table->foreignId('user_id')->nullable()->references('id')->on('users');
            $table->foreignId('location_id')->references('id')->on('locations');
            $table->string('attachment')->nullable();
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
        Schema::dropIfExists('rows');
    }
};
