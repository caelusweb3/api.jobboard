<?php

use App\Employer;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);
            $table->string('email',40)->unique();
            $table->string('password');
            $table->string('employer_info',255)->nullable();
            $table->string('address')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('image')->nullable();
            $table->string('phone',11)->nullable();
            $table->string('first_login')->nullable()->default(Employer::FIRST_LOGIN);
            $table->string('verified')->default(Employer::UNVERIFIED_USER);
            $table->string('verification_token')->nullable();
            $table->text('api_token')->nullable();
            $table->string('linkedin',100)->nullable();
            $table->string('facebook',100)->nullable();
            $table->string('twitter',100)->nullable();
            $table->string('instagram',100)->nullable();
            $table->string('website',100)->nullable();

            $table->string('type')->default(Employer::EMPLOYER);
            $table->text('slug');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('employers');
    }
}
