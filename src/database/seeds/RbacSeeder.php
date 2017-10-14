<?php

use Illuminate\Database\Seeder;

class RbacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin')->insert([
            'name' => 'admin',
            'email' => '',
            'password' => bcrypt('admin'),
            'remember_token' => str_random(10),
        ]);
        /*
        factory('App\Model\Admin', 1)->create([
            'name' => 'admin',
            'email' => '',
            'password' => bcrypt('admin'),
            'remember_token' => str_random(10),
        ]);
        */
    }
}
