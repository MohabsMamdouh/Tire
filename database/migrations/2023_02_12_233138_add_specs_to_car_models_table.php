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
        Schema::table('car_models', function (Blueprint $table) {
            $table->string('cylinders')->nullable();
            $table->string('drive')->nullable();
            $table->string('eng_dscr')->nullable();
            $table->string('fueltype')->nullable();
            $table->string('fueltype1')->nullable();
            $table->string('mpgdata')->nullable();
            $table->string('phevblended')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('car_models', function (Blueprint $table) {
            $table->dropColumn('cylinders');
            $table->dropColumn('drive');
            $table->dropColumn('eng_dscr');
            $table->dropColumn('fueltype');
            $table->dropColumn('fueltype1');
            $table->dropColumn('mpgdata');
            $table->dropColumn('phevblended');

        });
    }
};
