<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_tags', function (Blueprint $table) {
           $table->integer('rate_id')->unsigned();
           $table->integer('tag_id')->unsigned();

           $table->foreign('rate_id')->references('id')->on('rates')->onDelete('cascade');
           $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rate_tags');
    }
}
