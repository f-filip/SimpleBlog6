<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new Category;
        $category->name = 'Category1';
        $category->save();

        $category2 = new Category;
        $category2->name = 'Category2';
        $category2->save();

        $category3 = new Category;
        $category3->name = 'Category3';
        $category3->save();
    }
}
