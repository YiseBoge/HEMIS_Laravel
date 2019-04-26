<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class OtherAttrition extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;



    // Enums //
    protected $enumTypes = [
        'CET' => 'CET',
        'CNCS' => 'CNCS',
        'CMHS' => 'CMHS',
        'CAES' => 'CAES',
        'CBE' => 'CBE',
        'CSSH' => 'CSSH',
    ];

    protected $enumCases = [
        'READMISSIONS_OF_NEXT_SEMESTER' => 'Readmission of Next Semester',
        'TRANSFER_FROM_OTHER_INSTITUTES' => 'Transfer from Other Institutes',
        'TRANSFERS_TO_OTHER_INSTITUTES' => 'Transfer to Other Inistitutes',
    ];
}
