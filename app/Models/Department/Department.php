<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null year_level
 * @property int department_name_id
 * @method static Collection where(array $array)
 */
class Department extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumYearLevels = [
        'ONE' => '1',
        'TWO' => '2',
        'THREE' => '3',
        'FOUR' => '4',
        'FIVE' => '5',
        'SIX' => '6',
        'SEVEN' => '7',
        'NONE' => 'None'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::deleting(function (Department $model) { // before delete() method call this
            $model->enrollments()->delete();
            $model->ruralStudentEnrollments()->delete();
            $model->disadvantagedStudentEnrollments()->delete();
            $model->specialRegionEnrollments()->delete();
            $model->specializingStudentEnrollments()->delete();
            $model->ageEnrollments()->delete();
            $model->jointProgramEnrollments()->delete();
            $model->exitExaminations()->delete();
            $model->degreeEmployments()->delete();
            $model->costSharings()->delete();
            $model->otherRegionStudents()->delete();

            $model->specialProgramTeachers()->delete();
            $model->upgradingStaffs()->delete();
            $model->staffLeaves()->delete();
            $model->academicStaffs()->delete();
            $model->postgraduateDiplomaTrainings()->delete();
            $model->teachers()->delete();

            $model->specialNeedStudents()->delete();
            $model->foreignStudents()->delete();
            $model->studentAttritions()->delete();
            $model->otherAttritions()->delete();
            $model->publicationsAndPatents()->delete();
            $model->researches()->delete();
            $model->diasporaCourses()->delete();
        });
    }

    /**
     * @return HasMany
     */
    public function enrollments()
    {
        return $this->hasMany('App\Models\Department\Enrollment');
    }

    /**
     * @return HasMany
     */
    public function ruralStudentEnrollments()
    {
        return $this->hasMany('App\Models\Department\RuralStudentEnrollment');
    }

    /**
     * @return HasMany
     */
    public function disadvantagedStudentEnrollments()
    {
        return $this->hasMany('App\Models\Department\DisadvantagedStudentEnrollment');
    }

    /**
     * @return HasMany
     */
    public function specialRegionEnrollments()
    {
        return $this->hasMany('App\Models\Department\SpecialRegionEnrollment');
    }

    /**
     * @return HasMany
     */
    public function specializingStudentEnrollments()
    {
        return $this->hasMany('App\Models\Department\SpecializingStudentsEnrollment');
    }

    /**
     * @return HasMany
     */
    public function ageEnrollments()
    {
        return $this->hasMany('App\Models\Institution\AgeEnrollment');
    }

    /**
     * @return HasMany
     */
    public function jointProgramEnrollments()
    {
        return $this->hasMany('App\Models\Department\JointProgramEnrollment');
    }

    /**
     * @return HasMany
     */
    public function exitExaminations()
    {
        return $this->hasMany('App\Models\Department\ExitExamination');
    }

    /**
     * @return HasMany
     */
    public function degreeEmployments()
    {
        return $this->hasMany('App\Models\Department\DegreeEmployment');
    }

    /**
     * @return HasMany
     */
    public function costSharings()
    {
        return $this->hasMany('App\Models\Department\CostSharing');
    }

    /**
     * @return HasMany
     */
    public function otherRegionStudents()
    {
        return $this->hasMany('App\Models\Department\OtherRegionStudent');
    }

    /**
     * @return HasMany
     */
    public function specialProgramTeachers()
    {
        return $this->hasMany('App\Models\Department\SpecialProgramTeacher');
    }

    /**
     * @return HasMany
     */
    public function upgradingStaffs()
    {
        return $this->hasMany('App\Models\Department\UpgradingStaff');
    }

    /**
     * @return HasMany
     */
    public function staffLeaves()
    {
        return $this->hasMany('App\Models\Department\StaffLeave');
    }

    /**
     * @return HasMany
     */
    public function academicStaffs()
    {
        return $this->hasMany('App\Models\Staff\AcademicStaff');
    }

    /**
     * @return HasMany
     */
    public function postgraduateDiplomaTrainings()
    {
        return $this->hasMany('App\Models\Department\PostGraduateDiplomaTraining');
    }

    /**
     * @return HasMany
     */
    public function teachers()
    {
        return $this->hasMany('App\Models\Department\Teacher');
    }

    /**
     * @return HasMany
     */
    public function specialNeedStudents()
    {
        return $this->hasMany('App\Models\Student\SpecialNeedStudent');
    }

    /**
     * @return HasMany
     */
    public function foreignStudents()
    {
        return $this->hasMany('App\Models\Student\ForeignStudent');
    }

    /**
     * @return HasMany
     */
    public function studentAttritions()
    {
        return $this->hasMany('App\Models\Department\StudentAttrition');
    }

    /**
     * @return HasMany
     */
    public function otherAttritions()
    {
        return $this->hasMany('App\Models\Department\OtherAttrition');
    }

    /**
     * @return HasMany
     */
    public function publicationsAndPatents()
    {
        return $this->hasMany('App\Models\Department\PublicationsAndPatents');
    }

    /**
     * @return HasMany
     */
    public function researches()
    {
        return $this->hasMany('App\Models\Band\Research');
    }

    /**
     * @return HasMany
     */
    public function diasporaCourses()
    {
        return $this->hasMany('App\Models\Department\DiasporaCourses');
    }

    /**
     * @param $colleges
     * @param $departmentNames
     * @return \Illuminate\Support\Collection
     */
    public static function byCollegesAndDepartmentNames($colleges, $departmentNames)
    {
        $returnable = collect();
        foreach ($colleges as $college) {
            foreach ($college->departments()->whereIn('department_name_id', $departmentNames->pluck('id'))->get() as $dep) {
                $returnable->add($dep);
            }
        }
        return $returnable;
    }

    /**
     * @return BelongsTo
     */
    public function departmentName()
    {
        return $this->belongsTo('App\Models\Department\DepartmentName');
    }

    /**
     * @return BelongsTo
     */
    public function college()
    {
        return $this->belongsTo('App\Models\College\College');
    }

    /**
     * @return HasMany
     */
    public function enrollmentsApproved()
    {
        return $this->hasMany('App\Models\Department\Enrollment')->where('approval_status', 'Approved');
    }

    /**
     * @return HasMany
     */
    public function ruralStudentEnrollmentsApproved()
    {
        return $this->hasMany('App\Models\Department\RuralStudentEnrollment')->where('approval_status', 'Approved');
    }

    /**
     * @return HasMany
     */
    public function disadvantagedStudentEnrollmentsApproved()
    {
        return $this->hasMany('App\Models\Department\DisadvantagedStudentEnrollment')->where('approval_status', 'Approved');
    }

    /**
     * @return HasMany
     */
    public function specialRegionEnrollmentsApproved()
    {
        return $this->hasMany('App\Models\Department\SpecialRegionEnrollment')->where('approval_status', 'Approved');
    }

    /**
     * @return HasMany
     */
    public function specializingStudentEnrollmentsApproved()
    {
        return $this->hasMany('App\Models\Department\SpecializingStudentsEnrollment')->where('approval_status', 'Approved');
    }

    /**
     * @return HasMany
     */
    public function ageEnrollmentsApproved()
    {
        return $this->hasMany('App\Models\Institution\AgeEnrollment')->where('approval_status', 'Approved');
    }

    /**
     * @return HasMany
     */
    public function jointProgramEnrollmentsApproved()
    {
        return $this->hasMany('App\Models\Department\JointProgramEnrollment')->where('approval_status', 'Approved');
    }

    /**
     * @return HasMany
     */
    public function exitExaminationsApproved()
    {
        return $this->hasMany('App\Models\Department\ExitExamination')->where('approval_status', 'Approved');
    }

    /**
     * @return HasMany
     */
    public function degreeEmploymentsApproved()
    {
        return $this->hasMany('App\Models\Department\DegreeEmployment')->where('approval_status', 'Approved');
    }

    /**
     * @return HasMany
     */
    public function costSharingsApproved()
    {
        return $this->hasMany('App\Models\Department\CostSharing')->where('approval_status', 'Approved');
    }

    /**
     * @return HasMany
     */
    public function otherRegionStudentsApproved()
    {
        return $this->hasMany('App\Models\Department\OtherRegionStudent');
    }

    /**
     * @return HasMany
     */
    public function specialProgramTeachersApproved()
    {
        return $this->hasMany('App\Models\Department\SpecialProgramTeacher')->where('approval_status', 'Approved');
    }

    /**
     * @return HasMany
     */
    public function upgradingStaffsApproved()
    {
        return $this->hasMany('App\Models\Department\UpgradingStaff')->where('approval_status', 'Approved');
    }

    /**
     * @return HasMany
     */
    public function postgraduateDiplomaTrainingsApproved()
    {
        return $this->hasMany('App\Models\Department\PostGraduateDiplomaTraining')->where('approval_status', 'Approved');
    }

    /**
     * @return HasMany
     */
    public function teachersApproved()
    {
        return $this->hasMany('App\Models\Department\Teacher')->where('approval_status', 'Approved');
    }

    /**
     * @return HasMany
     */
    public function studentAttritionsApproved()
    {
        return $this->hasMany('App\Models\Department\StudentAttrition')->where('approval_status', 'Approved');
    }

    /**
     * @return HasMany
     */
    public function otherAttritionsApproved()
    {
        return $this->hasMany('App\Models\Department\OtherAttrition')->where('approval_status', 'Approved');
    }

    /**
     * @return HasMany
     */
    public function researchesApproved()
    {
        return $this->hasMany('App\Models\Band\Research')->where('approval_status', 'Approved');
    }

    /**
     * @return HasMany
     */
    public function diasporaCoursesApproved()
    {
        return $this->hasMany('App\Models\Department\DiasporaCourses')->where('approval_status', 'Approved');
    }


}
