<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null student_type
 * @property array|string|null type
 * @property array|string|null case
 * @property array|string|null male_students_number
 * @property array|string|null female_students_number
 */
class StudentAttrition extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    // Enums //

    protected $enumStudentTypes = [
        'ALL' => 'All',
        'EMERGING_REGION_STUDENTS' => 'Emerging Region Students',
        'PASTORAL_REGION_STUDENTS' => 'Pastoral Region Students',
        'RURAL_AREA_STUDENTS' => 'Rural Area Students',
        'SPECIAL_NEED_STUDENTS' => 'Special Need Students',
        'ECONOMICALLY_DISADVANTAGED_STUDENTS' => 'Economically Disadvantaged Students',
        'FOREIGN_STUDENTS' => 'Foreign Students',
    ];

    protected $enumTypes = [
        'CET' => 'CET',
        'CNCS' => 'CNCS',
        'CMHS' => 'CMHS',
        'CAES' => 'CAES',
        'CBE' => 'CBE',
        'CSSH' => 'CSSH',
    ];
    protected $enumCases = [
        'ACADEMIC_DISMISSALS_WITH_READMISSION' => 'Academic Dismissals With Readmission',
        'ACADEMIC_DISMISSALS_FOR_GOOD' => 'Academic Dismissals For Good',
        'DISCIPLINE_DISMISSALS' => 'Discipline Dismissals',
        'WITHDRAWALS' => 'Withdrawals',
        'DROPOUTS' => 'Dropouts',
        'OTHERS' => 'Others',
    ];

    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }
}
