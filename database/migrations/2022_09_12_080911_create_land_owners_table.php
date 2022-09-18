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
        Schema::create('land_owners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('village');
            $table->string('district');
            $table->string('regency');
            $table->string('province');
            $table->string('ktp')->nullable();
            $table->string('kk')->nullable();
            $table->string('sph')->nullable();
            $table->string('alas_hak')->nullable();
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
        Schema::dropIfExists('land_owners');
    }
};
