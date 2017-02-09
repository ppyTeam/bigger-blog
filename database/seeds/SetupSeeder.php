<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class SetupSeeder extends Seeder
{
    protected $seeders = [
        SetupNav::class,
        SetupCategory::class,
        SetupTag::class,
        //SetupRBAC::class,
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
