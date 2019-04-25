<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    public function departmentName()
    {
        return $this->hasOne('App\Models\Band\DepartmentName');
    }

    public function studentAttritions()
    {
        return $this->hasMany('App\Models\Department\StudentAttrition');
    }

    public function otherAttritions()
    {
        return $this->hasMany('App\Models\Department\OtherAttrition');
    }

    public function disabledStudents()
    {
        return $this->hasMany('App\Models\Student\DisabledStudent');
    }

    public function foreignerStudents()
    {
        return $this->hasMany('App\Models\Student\ForeignerStudent');
    }
}
