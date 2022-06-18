<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_followers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('follow_from_person')->nullable()->unsigned();
            $table->unsignedBigInteger('follow_to_page')->nullable()->unsigned();

            $table->foreign('follow_from_person')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('follow_to_page')->references('id')->on('pages')->onDelete('cascade');
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
        Schema::dropIfExists('page_followers');
    }
}
