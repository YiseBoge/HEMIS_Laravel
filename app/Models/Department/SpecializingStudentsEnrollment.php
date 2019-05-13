<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class SpecializingStudentsEnrollment extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumStudentTypes = [
        'CURRENT' => 'Current',
        'PREVIOUS_YEAR' => 'Previous Year'
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
