<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class StaffAttrition extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    // Enums //
    protected $enumCases = [
        'GOVERNMENT_APPOINTMENT' => 'Diploma',
        'TRANSFER_TO_HIGHER_EDUCATION_INSTITUTIONS' => 'Bachelors',
        'TRANSFER_TO_OTHER_GOVERNMENT_AGENCIES' => 'M.D/D.V',
        'RESIGNATION' => 'Masters',
        'RETIREMENT' => 'PhD',
        'DEATH' => '< = Grade 10',
        'DISCIPLINE' => 'Grade 11',
        'OTHERS' => 'Grade 12'
    ];

    public function staff()
    {
        return $this->belongsTo('App\Models\Staff\Staff');
    }
}
