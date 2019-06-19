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

    function institutionsByPrivacy($isPrivate){
        $institutions = array();
        foreach ($this->instances as $instance) {            
            foreach ($instance->institutions as $institution) {
                if ($institution->institutionName->is_private == $isPrivate) {
                    $institutions[] = $institution;
                }
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

    function enrollment($sex, $educationLevel){
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {                      
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->enrollment($sex, $educationLevel);
        }

        return $total;
    }

    function specialNeedEnrollment($educationLevel){
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {                      
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->specialNeedEnrollment($educationLevel);
        }

        return $total;
    }

    function disadvantagedStudentEnrollment($educationLevel){
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {                      
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->disadvantagedStudentEnrollment($educationLevel);
        }

        return $total;
    }

    function emergingRegionsEnrollment($educationLevel){
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {                      
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->emergingRegionsEnrollment($educationLevel);
        }

        return $total;
    }

    function ruralAreasEnrollment($educationLevel){
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {                      
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->ruralAreasEnrollment($educationLevel);
        }

        return $total;
    }

    function dropout($sex, $type, $educationLevel){
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {                      
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->dropout($sex, $type, $educationLevel);
        }

        return $total;
    }

    function academicDismissal($sex, $type, $educationLevel){
        $total = 0;

        foreach ($this->institutionsByPrivacy(false) as $institution) {                      
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->academicDismissal($sex, $type, $educationLevel);
        }

        return $total;
    }
}