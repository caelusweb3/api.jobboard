<?php

use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',30);
            $table->string('surname',30);
            $table->string('email',50)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',100);
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('gender')->nullable();
            $table->integer('age')->nullable();
            $table->string('phone',11)->nullable();
            $table->string('image')->nullable();
            $table->string('rate')->nullable()->default("0");
            $table->string('first_login')->nullable()->default(User::FIRST_LOGIN);
            $table->string('address',100)->nullable();
            $table->string('personal_info',200)->nullable();
            $table->string('verified')->default(User::UNVERIFIED_USER);
            $table->string('verification_token')->nullable();
            $table->string('linkedin',100)->nullable();
            $table->string('facebook',100)->nullable();
            $table->string('twitter',100)->nullable();
            $table->string('instagram',100)->nullable();
            $table->text('slug');
            $table->text('api_token')->nullable();
            $table->string('type')->default(User::CANDIDATE);
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
        Schema::dropIfExists('users');
    }
}
