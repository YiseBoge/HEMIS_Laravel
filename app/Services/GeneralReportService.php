<?php

namespace App\Services;

use App\Models\College\College;
use App\Models\Institution\Instance;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class GeneralReportService
 * @package App\Services
 */
class GeneralReportService
{
    /**
     * @var array|Collection
     */
    private $instances = array();

    /**
     * GeneralReportService constructor.
     * @param $year
     */
    function __construct($year)
    {
        $this->instances = Instance::where('year', $year)->get();
    }

    /**
     * @param $sex
     * @param $educationLevel
     * @return int
     */
    function privateEnrollments($sex, $educationLevel)
    {
        $total = 0;

        foreach ($this->__institutionsByPrivacy(true) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->fullEnrollment($sex, $educationLevel);
        }

        return $total;
    }

    /**
     * @param $isPrivate
     * @return array
     */
    function __institutionsByPrivacy($isPrivate)
    {
        $institutions = array();
        foreach ($this->instances as $instance) {
            foreach ($instance->institutions as $institution) {
                if ($isPrivate) {
                    if ($institution->institutionName->is_private) {
                        $institutions[] = $institution;
                    }
                } else {
                    $institutions[] = $institution;
                }
            }
        }
        return $institutions;
    }


    /**
     * @param $sex
     * @param $educationLevel
     * @return int
     */
    function fullEnrollment($sex, $educationLevel)
    {
        $total = 0;

        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->fullEnrollment($sex, $educationLevel);
        }

        return $total;
    }

    /**
     * @param $sex
     * @param $educationLevel
     * @return int
     */
    function stemEnrollment($sex, $educationLevel)
    {
        $total = 0;

        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->stemEnrollment($sex, $educationLevel);
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

        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->specialNeedEnrollment($educationLevel);
        }

        return $total;
    }

    /**
     * @param $educationLevel
     * @return int
     */
    function economicallyPoorEnrollment($educationLevel)
    {
        $total = 0;

        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->disadvantagedStudentEnrollment($educationLevel);
        }

        return $total;
    }

    /**
     * @param $educationLevel
     * @return int
     */
    function emergingRegionsEnrollment($educationLevel)
    {
        $total = 0;

        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->emergingRegionsEnrollment($educationLevel);
        }

        return $total;
    }

    /**
     * @param $educationLevel
     * @return float|int
     */
    function ruralAreasEnrollment($educationLevel)
    {
        $total = 0;

        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->ruralAreasEnrollment($educationLevel);
        }

        $totalEnrollments = $this->fullEnrollment("All", $educationLevel);
        if ($totalEnrollments == 0) return 0;
        return $total / $totalEnrollments;
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

        foreach ($this->__institutionsByPrivacy(false) as $institution) {
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

        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->academicDismissal($sex, $type, $educationLevel);
        }

        return $total;
    }

    /**
     * @return int
     */
    function expatriateStaff()
    {
        $total = 0;

        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->expatriateStaff();
        }

        return $total;
    }

    /**
     * @return int
     */
    function academicStaffPublication()
    {
        $total = 0;

        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->academicStaffPublication();
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
        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->allAcademicStaff();
            $selected += $institutionService->academicStaffRate($sex, $otherRegion);
        }
        $returnable = $total == 0 ? 0 : $selected / $total;

        return $returnable;
    }

    /**
     * @return int
     */
    function exitExamination()
    {
        $total = 0;

        foreach ($this->__institutionsByPrivacy(false) as $institution) {
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

        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->degreeEmployment();
        }

        return $total;
    }

    /**
     * @param $sex
     * @param $educationLevel
     * @return float|int
     */
    function graduationData($sex, $educationLevel)
    {
        $total = 0;

        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->graduationData($sex, $educationLevel);
        }

        return $total;
    }

    /**
     * @return int
     */
    function enrollmentInScienceAndTechnology()
    {
        $total = 0;

        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->enrollmentInScienceAndTechnology();
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
        foreach ($this->__institutionsByPrivacy(false) as $institution) {
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

        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->nonUtilizedFunds();
        }

        return $total;
    }

    /**
     * @return int
     */
    function diasporaCourses()
    {
        $total = 0;

        foreach ($this->__institutionsByPrivacy(false) as $institution) {
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

        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->foreignStudents($educationLevel);
        }

        return $total;
    }

    /**
     * @return int
     */
    function patents()
    {
        $total = 0;

        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->patents();
        }

        return $total;
    }

    /**
     * @return int
     */
    function publicationByPostgraduates()
    {
        $total = 0;

        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->publicationByPostgraduates();
        }

        return $total;
    }

    /**
     * @return int
     */
    function academicAttrition()
    {
        $total = 0;

        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->academicAttrition();
        }

        return $total;
    }

    /**
     * @return int
     */
    function costSharing()
    {
        $total = 0;

        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->costSharing();
        }

        return $total;
    }

    /**
     * @return int
     */
    function nonAcademicAttrition()
    {
        $total = 0;

        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->nonAcademicAttrition();
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

        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->jointEnrollment($educationLevel);
        }

        return $total;
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
        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->allManagementStaff();
            $selected += $institutionService->managementStaffRate($sex, $otherRegion);
        }
        $returnable = $total == 0 ? 0 : $selected / $total;

        return $returnable;
    }

    /**
     * @return float|int
     */
    function qualifiedTeacherToStudent()
    {
        $total = $this->fullEnrollment('All', College::getEnum('education_level')['UNDERGRADUATE']) +
            $this->fullEnrollment("All", College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $this->fullEnrollment("All", College::getEnum('education_level')['POST_GRADUATE_PHD']);

        $selected = $this->qualifiedAcademicStaff();

        $returnable = $total == 0 ? 0 : $selected / $total;

        return $returnable;
    }

    /**
     * @return int|mixed
     */
    function qualifiedAcademicStaff()
    {
        $total = 0;

        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->qualifiedAcademicStaff();
        }

        return $total;
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
        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->allEnrollment();

            $selected += $institutionService->enrollmentsRate($sex, $otherRegion);
        }
        $returnable = $total == 0 ? 0 : $selected / $total;

        return $returnable;
    }

}