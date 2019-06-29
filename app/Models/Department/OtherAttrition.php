<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null type
 * @property string|null case
 * @property int male_students_number
 * @property int female_students_number
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

    /**
     * @return BelongsTo
     */
    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }
}
