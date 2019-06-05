<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class TechnicalStaff extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumStaffRanks = [
        'TECHNICAL_ASSISTANT_I' => 'Technical Assistant I',
        'TECHNICAL_ASSISTANT_II' => 'Technical Assistant II',
        'TECHNICAL_ASSISTANT_III' => 'Technical Assistant III',
        'OTHERS' => 'Others',
    ];


    public function general()
    {
        return $this->morphOne('App\Models\Staff\Staff', 'staffable');
    }

    public function college()
    {
        return $this->belongsTo('App\Models\College\College');
    }
}
