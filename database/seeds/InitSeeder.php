<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class InitSeeder extends Seeder
{
    protected $seeders=[
        NavSeeder::class,
    ];

    /**
     * 站点初始化数据填充器
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        foreach ($this->seeders as $each_seeder) {
            $this->call($each_seeder);
        }
        Model::unguard();
    }
}
