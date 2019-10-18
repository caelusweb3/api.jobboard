<?php

use App\Category;
use App\Employer;
use App\Job;
use App\Rate;
use App\Repeat;
use App\Tag;
use App\Team;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("SET FOREIGN_KEY_CHECKS=0");


        User::truncate();
        Employer::truncate();
        Repeat::truncate();
        Tag::truncate();
        Category::truncate();
        Job::truncate();
        Rate::truncate();
        Team::truncate();
        DB::table("job_users")->truncate();
        DB::table("team_users")->truncate();
        DB::table("rate_tags")->truncate();
        DB::table("favorites_jobs")->truncate();

        $this->call(CategorySeeder::class);
        $this->call(TagSeeder::class);



        factory(Employer::class, 20)->create();
        factory(User::class,20)->create();
        factory(Job::class, 20)->create();







    }
}
