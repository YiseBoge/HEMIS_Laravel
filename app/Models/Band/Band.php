<?php

namespace App\Models\Band;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Band extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumEducationLevels = [
        'UNDERGRADUATE' => 'Undergraduate',
        'GRADUATE' => 'Graduate',
    ];

    protected $enumEducationPrograms = [
        'REGULAR' => 'Regular',
        'EXTENTION' => 'Extension',
        'SUMMER' => 'Summer',
        'DISTANCE' => 'Distance',
    ];


    // Enums //

    public function bandName()
    {
        return $this->belongsTo('App\Models\Band\BandName');
    }

    public function studentAttritions()
    {
        return $this->hasMany('App\Models\Department\StudentAttrition');
    }

    public function college()
    {
        return $this->hasMany('App\Models\College\College');
    }
}
