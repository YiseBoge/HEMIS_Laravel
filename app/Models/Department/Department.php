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
        'NONE' => 'None'
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

    public function ruralStudentEnrollments()
    {
        return $this->hasMany('App\Models\Department\RuralStudentEnrollment');
    }

    public function disadvantagedStudentEnrollments()
    {
        return $this->hasMany('App\Models\Department\DisadvantagedStudentEnrollment');
    }

    public function emergingRegions()
    {
        return $this->hasMany('App\Models\Institution\EmergingRegion');
    }

    public function pastoralRegions()
    {
        return $this->hasMany('App\Models\Institution\PastoralRegion');
    }

    public function ageEnrollments()
    {
        return $this->hasMany('App\Models\Institution\AgeEnrollment');
    }

    public function jointProgramEnrollments(){
        return $this->hasMany('App\Models\Department\JointProgramEnrollment');
    }

    public function exitExaminations()
    {
        return $this->hasMany('App\Models\Department\ExitExamination');
    }

    public function degreeEmployments()
    {
        return $this->hasMany('App\Models\Department\DegreeEmployment');
    }

    public function costSharings()
    {
        return $this->hasMany('App\Models\Department\CostSharing');
    }

    public function otherRegionStudents()
    {
        return $this->hasMany('App\Models\Department\OtherRegionStudent');
    }

    public function specialProgramTeachers(){
        return $this->hasMany('App\Models\Department\SpecialProgramTeacher');
    }

    public function upgradingStaffs()
    {
        return $this->hasMany('App\Models\Department\UpgradingStaff');
    }

    public function staffLeaves()
    {
        return $this->hasMany('App\Models\Department\StaffLeave');
    }

    public function academicStaffs()
    {
        return $this->hasMany('App\Models\Staff\AcademicStaff');
    }

    public function postgraduateDiplomaTrainings()
    {
        return $this->hasMany('App\Models\Department\PostGraduateDiplomaTraining');
    }

    public function teachers()
    {
        return $this->hasMany('App\Models\Department\Teacher');
    }

    public function expatriates()
    {
        return $this->hasMany('App\Models\Department\ExpatriateStaff');
    }

    public function specialNeedStudents()
    {
        return $this->hasMany('App\Models\Student\SpecialNeedStudent');
    }

    public function foreignStudents()
    {
        return $this->hasMany('App\Models\Student\ForeignStudent');
    }

    public function studentAttritions()
    {
        return $this->hasMany('App\Models\Department\StudentAttrition');
    }

    public function otherAttritions()
    {
        return $this->hasMany('App\Models\Department\OtherAttrition');
    }

    public function publicationsAndPatents()
    {
        return $this->hasMany('App\Models\Department\PublicationsAndPatents');
    }

    public function researches()
    {
        return $this->hasMany('App\Models\Band\Research');
    }

    public function diasporaCourses()
    {
        return $this->hasMany('App\Models\Department\DiasporaCourses');
    }

    

}
