<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        \App\Models\User::factory(33)->create();
//        \App\Models\Memo::factory(20)->create();
//        \App\Models\Minute::factory(85)->create();
//        \App\Models\Department::factory(32)->create();
        \App\Models\UserDetail::factory(32)->create();
    }
}
