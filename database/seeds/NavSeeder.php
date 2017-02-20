<?php

use Illuminate\Database\Seeder;

class NavSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Nav::class, 1)->create([
            'type' => 0,
        ]);

        factory(App\Nav::class, 1)->create([
            'type' => 1,
            'icon' => 'github',
        ]);


    }
}
