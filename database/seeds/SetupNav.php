<?php

use Illuminate\Database\Seeder;

class SetupNav extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(App\Nav::class, 1)->create([
//            'name' => 'Home',
//            'url' => '/',
//            'flag' => true,
//            'icon' => '',
//        ]);
        factory(App\Nav::class, 1)->create([
            'name' => 'Blog',
            'url' => '/blog',
            'flag' => true,
            'icon' => '',
        ]);
        factory(App\Nav::class, 1)->create([
            'name' => 'Archives',
            'url' => '/archives',
            'flag' => true,
            'icon' => '',
        ]);
        factory(App\Nav::class, 1)->create([
            'name' => 'Tags',
            'url' => '/tags',
            'flag' => true,
            'icon' => '',
        ]);
        factory(App\Nav::class, 1)->create([
            'name' => 'Category',
            'url' => '/categories',
            'flag' => true,
            'icon' => '',
        ]);
        factory(App\Nav::class, 1)->create([
            'name' => 'About',
            'url' => '/about',
            'flag' => true,
            'icon' => '',
        ]);
    }
}
