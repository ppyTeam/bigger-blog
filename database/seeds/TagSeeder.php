<?php

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
        factory(App\Tag::class)->create([
            'tag_name' => 'tag1',
        ]);
        factory(App\Tag::class)->create([
            'tag_name' => 'tag2',
        ]);
        factory(App\Tag::class)->create([
            'tag_name' => 'tag3',
        ]);
    }
}
