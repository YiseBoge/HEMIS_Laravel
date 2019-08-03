<?php

use App\Models\Institution\RegionName;
use Illuminate\Database\Seeder;

class RegionNamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allRegions = [
            'Addis Ababa',
            'Afar Region',
            'Amhara Region',
            'Benishangul-Gumuz Region',
            'Dire Dawa',
            'Gambela Region',
            'Harari Region',
            'Oromia Region',
            'Somali Region',
            'Southern Nations, Nationalities, and Peoples\' Region',
            'Tigray Region',
        ];

        foreach ($allRegions as $region) {
            $regionName = new RegionName();
            $regionName->name = $region;

            $regionName->save();
        }
    }
}
