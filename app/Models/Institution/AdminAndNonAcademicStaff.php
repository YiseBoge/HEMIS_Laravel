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

    protected $enumEducationLevel=[
        'DIPLOMA'=>'diploma',
        'Bachelors'=>'bachelors',
        'MD_DV'=>'M.D/D.V',
        'MASTERS'=>'masters',
        'PHD'=>'phd',
        'SPECIALITY'=>'speciality'
    ];

    public function institution()
    {
        return $this->belongsTo('App\Models\Institution\Institution');
    }
}
