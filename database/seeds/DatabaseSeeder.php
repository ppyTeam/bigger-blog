<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    protected $seeders = [
        PostSeeder::class,
        CategorySeeder::class,
        TagSeeder::class,
        PostTagCategorySeeder::class,
        NavSeeder::class,
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        Model::unguard();
        foreach ($this->seeders as $each_seeder) {
            $this->call($each_seeder);
        }

        Model::unguard();

    }
}
