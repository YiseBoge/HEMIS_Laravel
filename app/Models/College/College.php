<?php

namespace App\Models\College;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    
    use Uuids;
    use Enums;

    public $incrementing = false;

    protected $enumEducationLevels = [
        'UNDERGRADUATE' => 'Undergraduate',
        'POST_GRADUATE_MASTERS' => 'Post Graduate(Masters)',
        'POST_GRADUATE_PHD' => 'Post Graduate(PhD)',
        'POST_DOCTRIAL' => 'Post Doctrial'
    ];

    protected $enumEducationPrograms = [
        'REGULAR' => 'Regular',
        'EXTENTION' => 'Extension',
        'SUMMER' => 'Summer',
        'DISTANCE' => 'Distance',
    ];

    public function technicalStaffs()
    {
        return $this->hasMany('App\Models\College\TechnicalStaff');
    }
}
