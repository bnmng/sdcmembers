<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('users')->insert(
        [
            'name' => 'Admin',
            'password' => bcrypt('Admin'),
            'email' => 'loads@ervinarchproducts.com',
            'is_admin' => true,
        ]);
    }
}
