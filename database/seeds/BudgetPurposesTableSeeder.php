<?php

use App\Models\Institution\BuildingPurpose;
use Illuminate\Database\Seeder;

class BudgetPurposesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allPurposes = ['Class Rooms', 'Library', 'Laboratories', 'Admin Purposes', 'Staff Residence', 'Cafeteria', 'Dormitories', 'Others'];

        foreach ($allPurposes as $purpose) {
            $buildingPurpose = new BuildingPurpose();
            $buildingPurpose->purpose = $purpose;

            $buildingPurpose->save();
        }

    }
}
