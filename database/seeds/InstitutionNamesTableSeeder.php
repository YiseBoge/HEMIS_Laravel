<?php

use App\Models\Institution\InstitutionName;
use Illuminate\Database\Seeder;

class InstitutionNamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allInstitutions = [
            'AAU' => 'Addis Ababa University',
        ];

        foreach ($allInstitutions as $acronym => $name) {
            $institutionName = new InstitutionName();
            $institutionName->acronym = $acronym;
            $institutionName->institution_name = $name;
            $institutionName->is_private = false;

            $institutionName->save();
        }
    }
}
