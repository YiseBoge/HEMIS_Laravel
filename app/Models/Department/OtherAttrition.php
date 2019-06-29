<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null type
 * @property array|string|null case
 * @property array|string|null male_students_number
 * @property array|string|null female_students_number
 */
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

    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }
}
