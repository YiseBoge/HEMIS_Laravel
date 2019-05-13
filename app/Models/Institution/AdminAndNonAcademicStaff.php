<?php

namespace App\Models\Institution;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class AdminAndNonAcademicStaff extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    protected $enumEducationLevels=[
        'DIPLOMA'=>'Diploma',
        'Bachelors'=>'Bachelors',
        'MD_DV'=>'M.D/D.V',
        'MASTERS'=>'Masters',
        'PHD'=>'P.h.d',
        'SPECIALITY'=>'Speciality'
    ];

    public function institution()
    {
        return $this->belongsTo('App\Models\Institution\Institution');
    }
}
