<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('weather_forecasts', function (Blueprint $table) {
            $table->string('dt')->nullable();
            $table->string('sunrise')->nullable();
            $table->string('sunset')->nullable();
            $table->string('temp')->nullable();
            $table->string('feels_like')->nullable();
            $table->string('wind_speed')->nullable();
            $table->string('wind_gust')->nullable();
            $table->string('wind_deg')->nullable();
            $table->string('dew_point')->nullable();
            $table->string('uvi')->nullable();
            $table->string('clouds')->nullable();
            $table->string('visibility')->nullable();
            $table->string('humidity')->nullable();
            $table->string('weather_main')->nullable();
            $table->string('weather_desc')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('weather_forecasts', function (Blueprint $table) {
            //
        });
    }
};
