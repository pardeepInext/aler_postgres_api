<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constant('users');
            $table->string('title');
            $table->enum('status', ['rent', 'sale']);
            $table->string('type');
            $table->string('price');
            $table->string('size');
            $table->string('year');
            $table->string('bedrooms');
            $table->string('bathroom');
            $table->string('garages');
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
        Schema::dropIfExists('properties');
    }
}
