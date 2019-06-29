<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null name
 * @property DateTime birth_date
 * @property string|null sex
 * @property string|null phone_number
 * @property string|null nationality
 * @property string|null job_title
 * @property int salary
 * @property int service_year
 * @property string|null employment_type
 * @property string|null dedication
 * @property string|null academic_level
 * @property bool is_expatriate
 * @property bool is_from_other_region
 * @property string|null remarks
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

    /**
     * @return HasOne
     */
    public function staffAttrition()
    {
        return $this->hasOne('App\Models\Staff\StaffAttrition');
    }

}
