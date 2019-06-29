<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null name
 * @property array|string|null birth_date
 * @property array|string|null sex
 * @property array|string|null phone_number
 * @property array|string|null nationality
 * @property array|string|null job_title
 * @property array|string|null salary
 * @property array|string|null service_year
 * @property array|string|null employment_type
 * @property array|string|null dedication
 * @property array|string|null academic_level
 * @property bool is_expatriate
 * @property bool is_from_other_region
 * @property array|string|null remarks
 * @method static Staff find(array|string|null $input)
 */
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

    public function staffAttrition()
    {
        return $this->hasOne('App\Models\Staff\StaffAttrition');
    }

}
