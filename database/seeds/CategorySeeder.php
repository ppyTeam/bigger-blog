<?php

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
        factory(App\Category::class)->create([
            'category_name'=>'blog',
        ]);
        factory(App\Category::class)->create([
            'category_name'=>'share',
        ]);
        factory(App\Category::class)->create([
            'category_name'=>'test',
        ]);
    }
}
