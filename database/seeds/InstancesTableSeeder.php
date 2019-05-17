<?php

use App\Models\Institution\Instance;
use Illuminate\Database\Seeder;

class InstancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $instance = new Instance();
        $instance->year = 'EXAMPLE YEAR';
        $instance->semester = 'EXAMPLE SEMESTER';

        $instance->save();
    }
}
