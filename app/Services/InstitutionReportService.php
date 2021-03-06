<?php

namespace App\Services;

use App\Models\Institution\Instance;
use App\Models\Institution\Institution;
use App\Models\Institution\InstitutionName;
use Exception;
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
    private function __previousYearEnrollment($sex, $educationLevel)
    {
        try {
            $current_year = $this->institutions[0]->instance->year;
            $previous_year = (string)(((int)$current_year) - 1);
            $service = new InstitutionReportService($this->institutions[0]->institutionName, $previous_year);
            return $service->fullEnrollment($sex, $educationLevel);
        } catch (Exception $ex) {
            return 0;
        }
    }


    /**
     * @param $sex
     * @param $educationLevel
     * @param $studentType
     * @return int
     */
    private function __previousYearGraduationData($sex, $educationLevel, $studentType)
    {
        try {
            $current_year = $this->institutions[0]->instance->year;
            $previous_year = (string)(((int)$current_year) - 1);
            $service = new InstitutionReportService($this->institutions[0]->institutionName, $previous_year);
            return $service->graduationData($sex, $educationLevel, $studentType);
        } catch (Exception $ex) {
            return 0;
        }
    }


    /**
     * @param $action
     * @param $sex
     * @return int
     */
    private function __previousYearDiaspora($action, $sex)
    {
        try {
            $current_year = $this->institutions[0]->instance->year;
            $previous_year = (string)(((int)$current_year) - 1);
            $service = new InstitutionReportService($this->institutions[0]->institutionName, $previous_year);
            return $service->diasporaParticipation($action, $sex);
        } catch (Exception $ex) {
            return 0;
        }
    }


    /**
     * @param $sex
     * @param $educationLevel
     * @param bool $from_previous
     * @return int
     */
    function fullEnrollment($sex, $educationLevel, $from_previous = false)
    {
        if ($from_previous) return $this->__previousYearEnrollment($sex, $educationLevel);
        $total = 0;
        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->fullEnrollment($sex, $educationLevel);
        }
        return $total;
    }


    /**
     * @param $sex
     * @param $educationLevel
     * @param string $age
     * @return int
     */
    function ageEnrollment($sex, $educationLevel, $age = '19')
    {
        $total = 0;
        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->ageEnrollment($sex, $educationLevel, $age);
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
        foreach ($this->institutions as $institution) {
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
        foreach ($this->institutions as $institution) {
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
        foreach ($this->institutions as $institution) {
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
        foreach ($this->institutions as $institution) {
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
     * @param $sex
     * @param bool $passed
     * @return int
     */
    function exitExamination($sex, $passed = false)
    {
        $total = 0;
        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->exitExamination($sex, $passed);
        }
        return $total;
    }

    /**
     * @return int
     */
    function degreeRelevantEmployment()
    {
        $total = 0;
        foreach ($this->institutions as $institution) {
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
     * @param $type
     * @param string $sex
     * @param bool $otherRegion
     * @param bool $attrition
     * @return float|int
     */
    function staff($type, $sex = 'All', $otherRegion = false, $attrition = false)
    {
        $total = 0;
        foreach ($this->institutions as $institution) {
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
        foreach ($this->institutions as $institution) {
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
        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->expatriateStaff($dedication);
        }
        return $total;
    }

    /**
     * @param string $action
     * @param string $sex
     * @param bool $fromPrevious
     * @return int
     */
    function diasporaParticipation($action = 'All', $sex = 'All', $fromPrevious = false)
    {
        if ($fromPrevious) return $this->__previousYearDiaspora($action, $sex);
        $total = 0;
        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->diasporaParticipation($action, $sex);
        }
        return $total;
    }

    /**
     * @param string $sponsorType
     * @param string $sex
     * @return int
     */
    function qualifiedInternships($sponsorType = 'All', $sex = 'All')
    {
        $total = 0;
        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->qualifiedInternships($sponsorType, $sex);
        }
        return $total;
    }

    /**
     * @param $sex
     * @param string $educationLevel
     * @param string $student_type
     * @param bool $fromPrevious
     * @return float|int
     */
    function graduationData($sex, $educationLevel = 'All', $student_type = 'All', $fromPrevious = false)
    {
        if ($fromPrevious) return $this->__previousYearGraduationData($sex, $educationLevel, $student_type);
        $total = 0;
        foreach ($this->institutions as $institution) {
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
        foreach ($this->institutions as $institution) {
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
        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->budgetNotFromGovernment();
        }
        return $total;
    }

    /**
     * @param bool $smart
     * @return int
     */
    function classrooms($smart = true)
    {
        $total = 0;
        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->classrooms($smart);
        }
        return $total;
    }

    /**
     * @return int
     */
    function improperlyUtilizedFunds()
    {
        $total = 0;
        foreach ($this->institutions as $institution) {
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
        foreach ($this->institutions as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->researchBudget();
        }
        return $total;
    }
}