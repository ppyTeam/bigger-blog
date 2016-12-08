<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\Post::class, 1)->create([
            'title' => 'Hello World',
            'content' => 'This is the first article of this system.',
            'updated_at' => date_create(),
            'user_id' => 1,
            'category_id' => 1,
        ]);
        factory(App\Post::class, 9)->create();
    }
}
