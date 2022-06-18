<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id')->nullable()->unsigned();
            $table->longText('post_content')->nullable();
            $table->boolean('is_published')->default(true);

            $table->foreign('person_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('person_posts');
    }
}
