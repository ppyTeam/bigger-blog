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
            'name' => 'Github',
            'url' => 'https://github.com/ppyTeam/bigger-blog/tree/dev',
            'type' => 1,
            'icon' => 'github',
        ]);
        factory(App\Nav::class, 1)->create([
            'name' => 'Weibo',
            'url' => 'http://weibo.com/',
            'type' => 1,
            'icon' => 'weibo',
        ]);
        factory(App\Nav::class, 1)->create([
            'name' => 'Steam',
            'url' => 'http://steamcommunity.com/',
            'type' => 1,
            'icon' => 'steam',
        ]);


    }
}
