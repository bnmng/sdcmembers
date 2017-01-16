<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('statuses')->insert(
        [
            [
                'name' => 'In Good Standing',
                'order' => 1,
                'is_voter' => 1,
                'is_quorum' => 1,
            ],
            [
                'name' => 'Pending',
                'order' => 2,
                'is_voter' => 0,
                'is_quorum' => 0,
            ],
            [
                'name' => 'Prospective',
                'order' => 3,
                'is_voter' => 0,
                'is_quorum' => 0,
            ],
            [
                'name' => 'Not In Good Standing',
                'order' => 4,
                'is_voter' => 0,
                'is_quorum' => 0,
            ],

        ]
    );
    }
}
