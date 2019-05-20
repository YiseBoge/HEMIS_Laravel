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

    protected $enumYearLevels=[
        'ONE'=>'1',
        'TWO'=>'2',
        'THREE'=>'3',
        'FOUR'=>'4',
        'FIVE'=>'5',
        'SIX'=>'6',
        'SEVEN'=>'7',
        'NONE'=>'None'
    ];

    public function departmentName()
    {
        return $this->belongsTo('App\Models\Department\DepartmentName');
    }

    public function college()
    {
        return $this->belongsTo('App\Models\College\College');
    }

    public function enrollments(){
        return $this->hasMany('App\Models\Department\Enrollment');
    }

    public function foreignStudentEnrollments(){
        return $this->hasMany('App\Models\Department\ForeignStudent');
    }

    public function specializingStudentEnrollments(){
        return $this->hasMany('App\Models\Department\SpecializingStudentsEnrollment');
    }

    public function specialProgramTeachers(){
        return $this->hasMany('App\Models\Department\SpecialProgramTeacher');
    }

    public function upgradingStaffs(){
        return $this->hasMany('App\Models\Department\UpgradingStaff');
    }
    public function staffLeaves(){
        return $this->hasMany('App\Models\Department\StaffLeave');
    }
    public function academicStaffs(){
        return $this->hasMany('App\Models\Department\AcademicStaff');
    }
    public function postgraduateDiplomaTrainings(){
        return $this->hasMany('App\Models\Department\PostGraduateDiplomaTraining');
    }
    public function teachers(){
        return $this->hasMany('App\Models\Department\Teacher');
    }
    public function expatriates(){
        return $this->hasMany('App\Models\Department\ExpatriateStaff');
    }


}
