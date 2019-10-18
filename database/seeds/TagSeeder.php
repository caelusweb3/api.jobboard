<?php

use App\Skill;
use App\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category= new Tag();
        $category->name='Güleryüzlü';
        $category->is_active= 'aktif';
        $category->save();

        $category= new Tag();
        $category->name='Dakik';
        $category->is_active= 'aktif';
        $category->save();


        $category= new Tag();
        $category->name='Girişken';
        $category->is_active= 'aktif';
        $category->save();


        $category= new Tag();
        $category->name='Takım Oyuncusu';
        $category->is_active= 'aktif';
        $category->save();


        $category= new Tag();
        $category->name='Saygılı';
        $category->is_active= 'aktif';
        $category->save();


        $category= new Tag();
        $category->name='Çalışkan';
        $category->is_active= 'aktif';
        $category->save();

        $skill= new Skill();
        $skill->name='Skill1';
        $skill->is_active= 'aktif';
        $skill->save();


        $skill= new Skill();
        $skill->name='Skill2';
        $skill->is_active= 'aktif';
        $skill->save();

        $skill= new Skill();
        $skill->name='Skill3';
        $skill->is_active= 'aktif';
        $skill->save();

        $skill= new Skill();
        $skill->name='Skill4';
        $skill->is_active= 'aktif';
        $skill->save();






    }
}
