<?php

namespace App\Services;

use App\Models\Institution\Instance;

class GeneralReportService
{
    private $instances = array();

    function __construct($year)
    {
        $this->instances = Instance::where('year', $year)->get();
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
                }
                $institutions[] = $institution;
            }
        }
        return $institutions;
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

    // and so go other functions

    function enrollment($sex, $educationLevel)
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->enrollment($sex, $educationLevel);
        }

        return $total;
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

        return $total / $totalEnrollments;
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
            $total += $institutionService->academicDismissal($sex, $type, $educationLevel);
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

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->academicStaffRate($sex, $otherRegion);
        }

        return $total;
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

        return $total / $totalEnrollments;
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

    function enrollmentInScienceAndTechnology()
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->enrollmentInScienceAndTechnology();
        }

        return $total;
    }

    function budgetNotFromGovernment(){
        $total = 0;
        $totalBudget = 0;
        foreach ($this->institutionsByPrivacy(false) as $institution) {                      
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->budgetNotFromGovernemnt();
            $totalBudget += $institutionService->totalBudget();
        }

        return $total / $totalBudget;
    }

    function nonUtilizedFunds(){
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

    function publicationByPostgrads()
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->publicationByPostgrads();
        }

        return $total;
    }

    function academicAttrition(){
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {                      
            $institutionService = new InstitutionService($institution);
            $total += $institutionService->academicAttrition();
        }

        return $total;
    }
    
    function costSharings()
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->costSharings();
        }

        return $total;
    }

    function nonAcademicAttrition(){
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
}