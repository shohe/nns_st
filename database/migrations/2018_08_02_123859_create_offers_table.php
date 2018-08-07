<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('cx_id');
            $table->string('menu');
            $table->integer('price');
            $table->dateTime('date_time');
            $table->integer('distance_range');
            $table->geometry('user_location');
            $table->integer('stylist_id')->nullable();
            $table->integer('hair_type');
            $table->string('comment')->nullable();
            $table->integer('charity_id');
            $table->boolean('is_closed')->default(false);
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
        Schema::dropIfExists('offers');
    }
}
