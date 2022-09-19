<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function PHPSTORM_META\type;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('row_id')->nullable()->references('id')->on('rows');
            $table->foreignId('tower_id')->nullable()->references('id')->on('towers');
            $table->foreignId('land_owner_id')->references('id')->on('land_owners');
            $table->string('type');
            $table->integer('area');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('lands');
    }
};
