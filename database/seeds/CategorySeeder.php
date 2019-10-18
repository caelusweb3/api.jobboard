<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $category= new Category();
        $category->name='Hizmet';
        $category->is_active= 'active';
        $category->save();

        $category= new Category();
        $category->name='Cafe/Restoran';
        $category->is_active= 'active';
        $category->save();

        $category= new Category();
        $category->name='Araştırma';
        $category->is_active= 'active';
        $category->save();

        $category= new Category();
        $category->name='Organizasyon';
        $category->is_active= 'active';
        $category->save();

        $category= new Category();
        $category->name='Endüstriyel';
        $category->is_active= 'active';
        $category->save();

        $category= new Category();
        $category->name='Yazılım';
        $category->is_active= 'active';
        $category->save();

        $category= new Category();
        $category->name='Tasarım';
        $category->is_active= 'active';
        $category->save();

        $category= new Category();
        $category->name='Şahsi';
        $category->is_active= 'active';
        $category->save();

    }
}
