<?php

namespace App\Services;

use App\Models\College\College;
use App\Models\Institution\Instance;
use App\Models\Institution\Institution;
use App\Models\Institution\InstitutionName;
use Illuminate\Database\Eloquent\Collection;

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
            $this->institutions[] = Institution::where(array(
                'institution_name_id' => $institutionName->id,
                'instance_id' => $instance->id))->get()->first();
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

    /**
     * @param $educationLevel
     * @return int|mixed
     */
    function specialNeedEnrollment($educationLevel)
    {
        $total = 0;

        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->specialNeedEnrollment($educationLevel);
        }

        return $total;
    }

    /**
     * @param $sex
     * @param $type
     * @param $educationLevel
     * @return int
     */
    function dropout($sex, $type, $educationLevel)
    {
        $total = 0;

        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->dropout($sex, $type, $educationLevel);
        }

        return $total;
    }

    /**
     * @param $sex
     * @param $type
     * @param $educationLevel
     * @return int
     */
    function academicDismissal($sex, $type, $educationLevel)
    {
        $total = 0;

        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->academicDismissal($sex, $type, $educationLevel);
        }

        return $total;
    }

    /**
     * @param $sex
     * @param $educationLevel
     * @return float|int
     */
    function graduationRate($sex, $educationLevel)
    {
        $total = 0;

        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->graduationRate($sex, $educationLevel);
        }

        $totalEnrollments = $this->enrollment($sex, $educationLevel);
        if ($totalEnrollments == 0) return 0;

        return $total / $totalEnrollments;
    }

    /**
     * @return int
     */
    function academicAttrition()
    {
        $total = 0;

        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->academicAttrition();
        }

        return $total;
    }

    /**
     * @return int
     */
    function nonAcademicAttrition()
    {
        $total = 0;

        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->nonAcademicAttrition();
        }

        return $total;
    }

    /**
     * @return int|mixed
     */
    function qualifiedStaff()
    {
        $total = 0;

        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->qualifiedStaff();
        }

        return $total;
    }

    /**
     * @return float|int
     */
    function qualifiedTeacherToStudent()
    {
        $total = $this->enrollment('All', College::getEnum('education_level')['UNDERGRADUATE']) +
            $this->enrollment("All", College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $this->enrollment("All", College::getEnum('education_level')['POST_GRADUATE_PHD']);

        $selected = $this->qualifiedStaff();

        $returnable = $total == 0 ? 0 : $selected / $total;

        return $returnable;
    }

    /**
     * @return int
     */
    function exitExamination()
    {
        $total = 0;

        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->exitExamination();
        }

        return $total;
    }

    /**
     * @return int
     */
    function degreeEmployment()
    {
        $total = 0;

        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->degreeEmployment();
        }

        return $total;
    }

    /**
     * @return int
     */
    function academicStaffPublication()
    {
        $total = 0;

        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->academicStaffPublication();
        }

        return $total;
    }

    /**
     * @return int
     */
    function publicationByPostgraduates()
    {
        $total = 0;

        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->publicationByPostgraduates();
        }

        return $total;
    }

    /**
     * @return int
     */
    function patents()
    {
        $total = 0;

        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->patents();
        }

        return $total;
    }

    /**
     * @param $sex
     * @param $otherRegion
     * @return float|int
     */
    function academicStaffRate($sex, $otherRegion)
    {
        $total = 0;

        $selected = 0;
        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->allAcademicStaff();
            $selected += $institutionService->academicStaffRate($sex, $otherRegion);
        }
        $returnable = $total == 0 ? 0 : $selected / $total;

        return $returnable;
    }

    /**
     * @param $sex
     * @param $otherRegion
     * @return float|int
     */
    function managementStaffRate($sex, $otherRegion)
    {
        $total = 0;

        $selected = 0;
        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->allManagementStaff();
            $selected += $institutionService->managementStaffRate($sex, $otherRegion);
        }
        $returnable = $total == 0 ? 0 : $selected / $total;

        return $returnable;
    }

    /**
     * @param $sex
     * @param $otherRegion
     * @return float|int
     */
    function enrollmentsRate($sex, $otherRegion)
    {
        $total = 0;

        $selected = 0;
        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->allEnrollment();

            $selected += $institutionService->enrollmentsRate($sex, $otherRegion);
        }
        $returnable = $total == 0 ? 0 : $selected / $total;

        return $returnable;
    }

    /**
     * @return int
     */
    function diasporaCourses()
    {
        $total = 0;

        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->diasporaCourses();
        }

        return $total;
    }

    /**
     * @param $educationLevel
     * @return int
     */
    function foreignStudents($educationLevel)
    {
        $total = 0;

        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->foreignStudents($educationLevel);
        }

        return $total;
    }

    /**
     * @param $educationLevel
     * @return int
     */
    function jointEnrollment($educationLevel)
    {
        $total = 0;

        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->jointEnrollment($educationLevel);
        }

        return $total;
    }

    /**
     * @return int
     */
    function expatriateStaff()
    {
        $total = 0;

        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->expatriateStaff();
        }

        return $total;
    }

    /**
     * @return float|int
     */
    function budgetNotFromGovernment()
    {
        $total = 0;
        $totalBudget = 0;
        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->budgetNotFromGovernment();
            $totalBudget += $institutionService->totalBudget();
        }

        if ($totalBudget == 0) return 0;
        return $total / $totalBudget;
    }

    /**
     * @return int
     */
    function nonUtilizedFunds()
    {
        $total = 0;

        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->nonUtilizedFunds();
        }

        return $total;
    }


    /**
     * @return int
     */
    function unjustifiableExpenses()
    {
        $total = 0;

        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->unjustifiableExpenses();
        }

        return $total;
    }
}