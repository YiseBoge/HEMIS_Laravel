<?php

use App\Models\Band\BandName;
use Illuminate\Database\Seeder;

class BandNamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allBands = [
            'Band 1' => 'Engineering and Technology',
            'Band 2' => 'Natural and Computational Sciences',
            'Band 3' => 'Medicine and Health Sciences',
            'Band 4' => 'Agriculture and Life Sciences',
            'Band 5' => 'Business and Economics',
            'Band 6' => 'Social Sciences & Humanities',
        ];

        foreach ($allBands as $acronym => $name) {
            $bandName = new BandName();
            $bandName->acronym = $acronym;
            $bandName->band_name = $name;

            $bandName->save();
        }
    }
}
