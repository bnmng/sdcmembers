<?php

use Illuminate\Database\Seeder;

class PositionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('position_types')->insert(
        [
            [
                'name' => 'Chairperson',
                'order' => 1,
            ],

        ]
        );
    }
}
