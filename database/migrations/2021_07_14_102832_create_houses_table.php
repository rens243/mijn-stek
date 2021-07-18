<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('estate_id');
            $table->string('description');
            $table->string('photo');
            $table->string('price');
            $table->string('link');
            $table->text('raw');
            $table->timestamps();

            $table->foreign('estate_id')->references('id')->on('estates')->cascadeOnDelete();
            $table->unique(['name', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('houses');
    }
}
