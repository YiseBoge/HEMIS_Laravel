<?php

namespace App\Services;

use App\Models\Institution\Instance;

class GeneralReportService
{
    private $instances = array();

    function __construct($year)
    {
        $this->instances = Instance::where('year', $year);
    }

    function institutionsByPrivacy($isPrivate){
        $institutions = array();
        foreach ($this->instances as $instance) {
            foreach ($instance->institutions() as $institution) {
                if ($institution->institutionName->is_private == $isPrivate) {
                    $institutions[] = $institution;
                }
            }
        }
    }

    function privateEnrollments()
    {
        $total = 0;

        foreach ($this->institutionsByPrivacy(true) as $institution) {
            $institutionService = new InstitutionService($institution);
            
        }
    }

    // and so go other functions

    function enrollment($sex, $educationLevel){
        $total = 0;

        foreach ($this->institutionsByPrivacy(true) as $institution) {
            $institutionService = new InstitutionService($institution);
            $total = $institutionService->enrollment($sex, $educationLevel);
        }

        return $total;
    }
}