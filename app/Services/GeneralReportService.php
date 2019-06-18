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

    function privateEnrollments()
    {
        $result = 0;

        foreach ($this->instances as $instance) {
            foreach ($instance->institutions()->where(/* do filtering here*/) as $institution) {
                $institutionService = new InstitutionService($institution);

                //can now call all institution service methods and add them to the result
            }
        }
    }

    // and so go other functions
}