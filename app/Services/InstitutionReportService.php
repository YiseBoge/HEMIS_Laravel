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

    // function code goes here
}