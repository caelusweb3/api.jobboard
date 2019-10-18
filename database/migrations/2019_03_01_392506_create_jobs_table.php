<?php

use App\Job;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employer_id')->unsigned();
            $table->integer('category_id')->nullable()->unsigned();
            $table->integer('repeat_id')->nullable()->unsigned();
            $table->string('person_count')->nullable();
            $table->string('wear')->nullable();
            $table->string('tool')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('week_day')->nullable();
            $table->string('tarif')->nullable();
            $table->string('title',100);
            $table->string('taslak');
            $table->string('work_style')->default(Job::GUNLUK);
            $table->string('address',100);
            $table->integer('fee');
            $table->string('description',4000);
            $table->string('begin_date');
            $table->text('slug');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employer_id')->references('id')->on('employers');
            $table->foreign('category_id')->references('id')->on('categories');


        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
