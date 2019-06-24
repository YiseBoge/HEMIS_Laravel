<?php

namespace App\Services;

use App\Models\College\College;
use App\Models\Institution\Instance;

class GeneralReportService
{
    private $instances = array();

    function __construct($year)
    {
        $this->instances = Instance::where('year', $year)->get();
    }

    function privateEnrollments($educationLevel)
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(true) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->enrollment('All', $educationLevel);
        }

        return $total;
    }

    function institutionsByPrivacy($isPrivate)
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

    function specialNeedEnrollment($educationLevel)
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->specialNeedEnrollment($educationLevel);
        }

        return $total;
    }

    function disadvantagedStudentEnrollment($educationLevel)
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->disadvantagedStudentEnrollment($educationLevel);
        }

        return $total;
    }

    function emergingRegionsEnrollment($educationLevel)
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->emergingRegionsEnrollment($educationLevel);
        }

        return $total;
    }

    function ruralAreasEnrollment($educationLevel)
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->ruralAreasEnrollment($educationLevel);
        }

        $totalEnrollments = $this->enrollment("All", $educationLevel);
        if ($totalEnrollments == 0) return 0;
        return $total / $totalEnrollments;
    }

    function enrollment($sex, $educationLevel)
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->enrollment($sex, $educationLevel);
        }

        return $total;
    }

    function dropout($sex, $type, $educationLevel)
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->dropout($sex, $type, $educationLevel);
        }

        return $total;
    }

    function academicDismissal($sex, $type, $educationLevel)
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->academicDismissal($sex, $type, $educationLevel);
        }

        return $total;
    }

    function expatriateStaff()
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->expatriateStaff();
        }

        return $total;
    }

    function academicStaffPublication()
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->academicStaffPublication();
        }

        return $total;
    }

    function academicStaffRate($sex, $otherRegion)
    {
        $total = 0;

        $selected = 0;
        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->allAcademicStaff();
            $selected += $institutionService->academicStaffRate($sex, $otherRegion);
        }
        $returnable = $total == 0 ? 0 : $selected / $total;

        return $returnable;
    }

    function exitExamination()
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->exitExamination();
        }

        return $total;
    }

    function degreeEmployment()
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->degreeEmployment();
        }

        return $total;
    }

    function graduationRate($sex, $educationLevel)
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->graduationRate($sex, $educationLevel);
        }

        $totalEnrollments = $this->enrollment("All", $educationLevel);
        if ($totalEnrollments == 0) return 0;

        return $total / $totalEnrollments;
    }

    function enrollmentInScienceAndTechnology()
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->enrollmentInScienceAndTechnology();
        }

        return $total;
    }

    function budgetNotFromGovernment()
    {
        $total = 0;
        $totalBudget = 0;
        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->budgetNotFromGovernment();
            $totalBudget += $institutionService->totalBudget();
        }

        if ($totalBudget == 0) return 0;
        return $total / $totalBudget;
    }

    function nonUtilizedFunds()
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->nonUtilizedFunds();
        }

        return $total;
    }

    function diasporaCourses()
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->diasporaCourses();
        }

        return $total;
    }

    function foreignStudents($educationLevel)
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->foreignStudents($educationLevel);
        }

        return $total;
    }

    function patents()
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->patents();
        }

        return $total;
    }

    function publicationByPostgraduates()
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->publicationByPostgraduates();
        }

        return $total;
    }

    function academicAttrition()
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->academicAttrition();
        }

        return $total;
    }

    function costSharing()
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->costSharing();
        }

        return $total;
    }

    function nonAcademicAttrition()
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->nonAcademicAttrition();
        }

        return $total;
    }

    function jointEnrollment($educationLevel)
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->jointEnrollment($educationLevel);
        }

        return $total;
    }

    function managementStaffRate($sex, $otherRegion)
    {
        $total = 0;

        $selected = 0;
        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->allManagementStaff();
            $selected = $institutionService->managementStaffRate($sex, $otherRegion);
        }
        $returnable = $total == 0 ? 0 : $selected / $total;

        return $returnable;
    }

    function qualifiedTeacherToStudent()
    {
        $total = $this->enrollmentsRate("All", College::getEnum('education_level')['UNDERGRADUATE']) +
            $this->enrollmentsRate("All", College::getEnum('education_level')['POST_GRADUATE_MASTERS']) +
            $this->enrollmentsRate("All", College::getEnum('education_level')['POST_GRADUATE_PHD']);

        $selected = $this->qualifiedStaff();

        $returnable = $total == 0 ? 0 : $selected / $total;

        return $returnable;
    }

    function enrollmentsRate($sex, $otherRegion)
    {
        $total = 0;

        $selected = 0;
        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->allEnrollment();

            $selected += $institutionService->enrollmentsRate($sex, $otherRegion);
        }
        $returnable = $total == 0 ? 0 : $selected / $total;

        return $returnable;
    }

    function qualifiedStaff()
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->qualifiedStaff();
        }

        return $total;
    }

}