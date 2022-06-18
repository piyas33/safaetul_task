<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_followers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('follow_from')->nullable()->unsigned();
            $table->unsignedBigInteger('follow_to')->nullable()->unsigned();

            $table->foreign('follow_from')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('follow_to')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('person_followers');
    }
}
