<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    // Enums //
    protected $enumAcademicLevels = [
        'DIPLOMA' => 'Diploma',
        'BACHELORS' => 'Bachelors',
        'MD_DV' => 'M.D/D.V',
        'MASTERS' => 'Masters',
        'PHD' => 'PhD',
        'G10' => '< = Grade 10',
        'G11' => 'Grade 11',
        'G12' => 'Grade 12',
        '10+1' => '10 + 1',
        '10+2' => '10 + 2',
        '10+3' => '10 + 3',
        'LI' => 'Level I',
        'LII' => 'Level II',
        'LIII' => 'Level III',
        'LIV' => 'Level IV',
        'Lv' => 'Level V',
    ];

    protected $enumDedications = [
        'FULL' => 'Full Time',
        'PART' => 'Part Time',
    ];

    protected $enumSexs = [
        'MALE' => 'male',
        'FEMALE' => 'female',
    ];

    protected $enumEmploymentTypes = [
        'EMPLOYEE' => 'Employee',
        'CONTRACTOR' => 'Contractor',
    ];


}
