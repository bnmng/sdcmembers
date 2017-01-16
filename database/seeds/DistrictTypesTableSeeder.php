<?php

use Illuminate\Database\Seeder;

class DistrictTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('district_types')->insert(
        [
            [
                'name_long' => 'Congressional District',
                'name_short' => 'Congress',
                'order' => 1,
            ],
            [
                'name_long' => 'House of Delegates District',
                'name_short' => 'HOD',
                'order' => 11,
            ],
            [
                'name_long' => 'State Senate District',
                'name_short' => 'VA Sen',
                'order' => 12,
            ],
            [
                'name_long' => 'Borough',
                'name_short' => 'Boro',
                'order' => 21,
            ],
            [
                'name_long' => 'Precinct',
                'name_short' => 'Prec',
                'order' => 22,
            ]
        ]

        );
    }
}
