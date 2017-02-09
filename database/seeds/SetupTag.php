<?php

use Illuminate\Database\Seeder;

class SetupTag extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Tag::class)->create([
            'tag_name' => 'MarkDown',
        ]);
    }
}
