<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class StudentAttrition extends Model
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
        'ACADEMIC_DISMISSALS_WITH_READMISSION' => 'Academic Dismissals With Readmission',
        'ACADEMIC_DISMISSALS_FOR_GOOD' => 'Academic Dismissals For Good',
        'DISCIPLINE_DISMISSALS' => 'Discipline Dismissals',
        'WITHDRAWALS' => 'Withdrawals',
        'DROPOUTS' => 'Dropouts',
        'OTHERS' => 'Others',
    ];

    public function band()
    {
        return $this->belongsTo('App\Models\Band\Band');
    }

}
