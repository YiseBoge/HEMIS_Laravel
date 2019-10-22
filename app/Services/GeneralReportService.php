<?php

namespace App\Services;

use App\Models\Institution\Instance;
use Exception;
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
     * @param bool $private
     * @return int
     */
    private function previousYearEnrollment($sex, $educationLevel, $private)
    {
        try {
            $current_year = $this->instances[0]->year;
            $previous_year = (string)(((int)$current_year) - 1);
            $service = new GeneralReportService($previous_year);
            return $service->fullEnrollment($sex, $educationLevel, $private);
        } catch (Exception $ex) {
            return 0;
        }
    }


    /**
     * @param $sex
     * @param $educationLevel
     * @param bool $private
     * @param bool $from_previous
     * @return int
     */
    function fullEnrollment($sex, $educationLevel, $private = false, $from_previous = false)
    {
        if ($from_previous) return $this->previousYearEnrollment($sex, $educationLevel, $private);
        $total = 0;
        foreach ($this->__institutionsByPrivacy($private) as $institution) {
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
     * @return int
     */
    function degreeRelevantEmployment()
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
     * @param $type
     * @param string $sex
     * @param bool $otherRegion
     * @param bool $attrition
     * @return float|int
     */
    function staff($type, $sex = 'All', $otherRegion = false, $attrition = false)
    {
        $total = 0;
        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->staff($type, $sex, $otherRegion, $attrition);
        }
        return $total;
    }

    /**
     * @param string $sex
     * @return int|mixed
     */
    function qualifiedAcademicStaff($sex = 'All')
    {
        $total = 0;
        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->qualifiedAcademicStaff($sex);
        }
        return $total;
    }

    /**
     * @param string $dedication
     * @return int
     */
    function expatriateStaff($dedication = 'Full Time')
    {
        $total = 0;
        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->expatriateStaff($dedication);
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
     * @param $sex
     * @param $educationLevel
     * @param string $student_type
     * @return float|int
     */
    function graduationData($sex, $educationLevel = 'All', $student_type = 'All')
    {
        $total = 0;
        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->graduationData($sex, $educationLevel, $student_type);
        }
        return $total;
    }

    /**
     * @return float|int
     */
    function totalBudget()
    {
        $total = 0;
        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->totalBudget();
        }
        return $total;
    }

    /**
     * @return float|int
     */
    function budgetNotFromGovernment()
    {
        $total = 0;
        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->budgetNotFromGovernment();
        }
        return $total;
    }

    /**
     * @return int
     */
    function improperlyUtilizedFunds()
    {
        $total = 0;
        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->improperlyUtilizedFunds();
        }
        return $total;
    }

    /**
     * @return int
     */
    function researchBudget()
    {
        $total = 0;
        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->researchBudget();
        }
        return $total;
    }

    /**
     * @param $purpose
     * @return int
     */
    function buildings($purpose)
    {
        $total = 0;
        foreach ($this->__institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->researchBudget();
        }
        return $total;
    }
}