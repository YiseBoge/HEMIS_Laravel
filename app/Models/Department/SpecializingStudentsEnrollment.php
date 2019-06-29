<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null male_students_number
 * @property array|string|null female_students_number
 * @property array|string|null student_type
 * @property array|string|null specialization_type
 * @property array|string|null field_of_specialization
 */
class SpecializingStudentsEnrollment extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumStudentTypes = [
        'CURRENT' => 'Current',
        'PREVIOUS_YEAR_GRADUATES' => 'Previous Year Graduates',
        'PROSPECTIVE_GRADUATES' => 'Prospective Graduates'
    ];

    protected $enumSpecializationTypes = [
        'SPECIALIZATION' => 'Specialization',
        'SUB_SPECIALIZATION' => 'Sub Specialization'
    ];

    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }

    public function scopeInfo($query)
    {
        return $query->with('department.college.band', 'department.departmentName');
    }
}
