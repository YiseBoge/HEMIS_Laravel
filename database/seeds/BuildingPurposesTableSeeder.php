<?php

use App\Models\Institution\BuildingPurpose;
use Illuminate\Database\Seeder;

class BuildingPurposesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allPurposes = ['Smart Classrooms', 'Class Rooms', 'Library', 'Laboratories', 'Admin Purposes', 'Staff Residence', 'Cafeteria', 'Dormitories', 'Others'];

        foreach ($allPurposes as $purpose) {
            $buildingPurpose = new BuildingPurpose();
            $buildingPurpose->purpose = $purpose;

            $buildingPurpose->save();
        }

    }
}
