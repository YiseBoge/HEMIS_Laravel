<?php

use App\Models\Staff\JobTitle;
use Illuminate\Database\Seeder;

class JobTitlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $title = new JobTitle();
        $title->staff_type = "Academic";
        $title->level = "Level 1";
        $title->job_title = 'Lecturer';
        $title->save();

        $title = new JobTitle();
        $title->staff_type = "Administrative";
        $title->level = "Level 1";
        $title->job_title = 'Administrative Job';
        $title->save();

        $title = new JobTitle();
        $title->staff_type = "Management";
        $title->level = "Level 1";
        $title->job_title = 'Vice President';
        $title->save();

        $title = new JobTitle();
        $title->staff_type = "Technical";
        $title->level = "Level 1";
        $title->job_title = 'Administrative Job';
        $title->save();
    }
}
