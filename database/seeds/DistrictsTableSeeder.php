<?php

use Illuminate\Database\Seeder;

class DistrictsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $congress_id = App\DistrictType::where('name_short', 'Congress')->first()['id'];
        $hod_id = App\DistrictType::where('name_short', 'HOD')->first()['id'];
        $vas_id = App\DistrictType::where('name_short', 'VA Sen')->first()['id'];
        $precinct_id = App\DistrictType::where('name_short', 'Prec')->first()['id'];

       DB::table('districts')->insert(
        [
            [
                'district_type_id' => $congress_id,
                'name' => '3',
                'votebuilder_id' => '003',
            ],
            [
                'district_type_id' => $congress_id,
                'name' => '4',
                'votebuilder_id' => '004',
            ],
            [
                'district_type_id' => $hod_id,
                'name' => '64',
                'votebuilder_id' => '064',
            ],
            [
                'district_type_id' => $hod_id,
                'name' => '76',
                'votebuilder_id' => '076',
            ],
            [
                'district_type_id' => $hod_id,
                'name' => '77',
                'votebuilder_id' => '077',
            ],
            [
                'district_type_id' => $hod_id,
                'name' => '80',
                'votebuilder_id' => '080',
            ],
            [
                'district_type_id' => $vas_id,
                'name' => '01',
                'votebuilder_id' => '001',
            ],
            [
                'district_type_id' => $vas_id,
                'name' => '03',
                'votebuilder_id' => '003',
            ],
            [
                'district_type_id' => $vas_id,
                'name' => '14',
                'votebuilder_id' => '014',
            ],
            [
                'district_type_id' => $vas_id,
                'name' => '18',
                'votebuilder_id' => '018',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '101 - Belleharbour',
                'votebuilder_id' => '1706904',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '102 - Driver',
                'votebuilder_id' => '297599',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '104 - Bennetts Creek',
                'votebuilder_id' => '297602',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '201 - Ebenezer',
                'votebuilder_id' => '297603',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '202 - Chuckatuck',
                'votebuilder_id' => '297604',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '203 - Kings Fork',
                'votebuilder_id' => '297605',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '204 - Hillpoint',
                'votebuilder_id' => '1706905',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '301 - White Marsh',
                'votebuilder_id' => '297606',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '302 - John F Kennedy',
                'votebuilder_id' => '297607',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '304 - Nansemond River',
                'votebuilder_id' => '297624',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '305 - Shoulders Hill',
                'votebuilder_id' => '1706906',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '401 - Airport',
                'votebuilder_id' => '297611',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '402 - Whaleyville',
                'votebuilder_id' => '297613',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '403 - Southside',
                'votebuilder_id' => '297615',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '404 - Booker T Washington',
                'votebuilder_id' => '1706907',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '405 - Pittmantown',
                'votebuilder_id' => '1706908',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '501 - Kilbys Mill',
                'votebuilder_id' => '297616',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '502 - Holland',
                'votebuilder_id' => '297617',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '504 - Lake Cohoon',
                'votebuilder_id' => '297619',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '601 - Lakeside',
                'votebuilder_id' => '297620',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '602 - Olde Towne',
                'votebuilder_id' => '297621',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '603 - Elephants Fork/Westhaven',
                'votebuilder_id' => '297622',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '604 - Wilroy',
                'votebuilder_id' => '1706909',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '605 - Hollywood',
                'votebuilder_id' => '297623',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '702 - Harbourview',
                'votebuilder_id' => '297601',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '704 - Burbage Grant',
                'votebuilder_id' => '1706910',
            ],
            [
                'district_type_id' => $precinct_id,
				'name' => '706 - Huntersville',
                'votebuilder_id' => '1706911',
            ]
        ]

        );
    }
}
