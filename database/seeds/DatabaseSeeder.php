<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesTableSeeder::class,
            UsersTableSeeder::class,

            BuildingPurposesTableSeeder::class,
            ReportCardsTableSeeder::class,

            IctStaffTypesTableSeeder::class,
            BudgetDescriptionsTableSeeder::class,
            RegionNamesTableSeeder::class,
            BandNamesTableSeeder::class,
            InstitutionNamesTableSeeder::class,
        ]);
    }
}
