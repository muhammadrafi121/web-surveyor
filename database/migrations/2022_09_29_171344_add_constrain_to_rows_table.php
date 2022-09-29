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
        Schema::table('rows', function (Blueprint $table) {
            $table->unsignedBigInteger('tower1_id')->constrained()->change();
            $table->unsignedBigInteger('tower2_id')->constrained()->change();
            $table->unsignedBigInteger('user_id')->constrained()->change();
            $table->unsignedBigInteger('location_id')->constrained()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rows', function (Blueprint $table) {
            //
        });
    }
};
