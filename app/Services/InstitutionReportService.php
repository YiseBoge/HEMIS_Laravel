<?php

namespace App\Services;

use App\Models\Institution\Instance;
use App\Models\Institution\InstitutionName;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class InstitutionReportService
 * @package App\Services
 */
class InstitutionReportService
{
    /**
     * @var array|Collection
     */
    private $institutions = array();

    /**
     * InstitutionReportService constructor.
     * @param InstitutionName $institutionName
     * @param string $year
     */
    function __construct(InstitutionName $institutionName, $year)
    {
        foreach (Instance::where('year', $year)->get() as $instance) {
            $this->institutions[] = DB::table('institutions')->where(array(
                'institution_name_id' => $institutionName->id,
                'instance_id' => $instance->id))->get();
        }
    }

    /**
     * @param $sex
     * @param $educationLevel
     * @return int
     */
    function enrollment($sex, $educationLevel)
    {
        $total = 0;

        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->enrollment($sex, $educationLevel);
        }

        return $total;
    }

    public function specialNeedEnrollment($UNDERGRADUATE)
    {
        return 0;
    }

    public function dropout($string, $string1, $UNDERGRADUATE)
    {
        return 0;
    }

    public function academicDismissal($string, $ALL, $UNDERGRADUATE)
    {
        return 0;
    }

    public function graduationRate($string, $UNDERGRADUATE)
    {
        return 0;
    }

    public function academicAttrition()
    {
        return 0;
    }

    public function nonAcademicAttrition()
    {
        return 0;
    }

    public function qualifiedStaff()
    {
        return 0;
    }

    public function qualifiedTeacherToStudent()
    {
        return 0;
    }

    public function exitExamination()
    {
        return 0;
    }

    public function degreeEmployment()
    {
        return 0;
    }

    public function academicStaffPublication()
    {
        return 0;
    }

    public function publicationByPostgraduates()
    {
        return 0;
    }

    public function patents()
    {
        return 0;
    }

    public function academicStaffRate($string, $false)
    {
        return 0;
    }

    public function managementStaffRate($string, $false)
    {
        return 0;
    }

    public function enrollmentsRate($string, $false)
    {
        return 0;
    }

    public function diasporaCourses()
    {
        return 0;
    }

    public function foreignStudents($UNDERGRADUATE)
    {
        return 0;
    }

    public function jointEnrollment($UNDERGRADUATE)
    {
        return 0;
    }

    public function expatriateStaff()
    {
        return 0;
    }

    public function budgetNotFromGovernment()
    {
        return 0;
    }

    public function nonUtilizedFunds()
    {
        return 0;
    }
}