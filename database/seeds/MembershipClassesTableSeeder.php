<?php

use Illuminate\Database\Seeder;

class MembershipClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('membership_classes')->insert(
        [
            [
                'name' => 'Precinct Member',
                'order' => 1,
                'is_voter' => true,
                'is_quorum' => true,
                'is_duespayer' => true,
                'has_status' => true,
            ],
            [
                'name' => 'Voting Ex-Officio',
                'order' => 2,
                'is_voter' => true,
                'is_quorum' => true,
                'is_duespayer' => true,
                'has_status' => true,
            ],
            [
                'name' => 'Non-Voting Ex-Officio',
                'order' => 3,
                'is_voter' => false,
                'is_quorum' => false,
                'is_duespayer' => false,
                'has_status' => true,
            ],
            [
                'name' => 'At Large',
                'order' => 4,
                'is_voter' => false,
                'is_quorum' => false,
                'is_duespayer' => false,
                'has_status' => false,
            ],
            [
                'name' => 'Business Sponsor',
                'order' => 5,
                'is_voter' => false,
                'is_quorum' => false,
                'is_duespayer' => false,
                'has_status' => false,
            ],
            [
                'name' => 'Affilliated Organization Member',
                'order' => 6,
                'is_voter' => false,
                'is_quorum' => false,
                'is_duespayer' => false,
                'has_status' => false,
            ],
            [
                'name' => 'Non-Member',
                'order' => 7,
                'is_voter' => false,
                'is_quorum' => false,
                'is_duespayer' => false,
                'has_status' => false,
            ],
        ]

        );
    }
}
