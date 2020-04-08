<?php

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tag = new tag;
        $tag->name = 'tag';
        $tag->save();

        $tag2 = new tag;
        $tag2->name = 'tag2';
        $tag2->save();

        $tag3 = new tag;
        $tag3->name = 'tag3';
        $tag3->save();
    }
    
}
