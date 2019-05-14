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
        'POST_DOCTRIAL' => 'Post Doctrial',
        'SPECIALIZATION' => 'Specialization',
<<<<<<< HEAD
        'NONE' => 'None'
=======
        'NONE'=>'none'
>>>>>>> e53315c6c8e631881469ae3b8ebeac0ff58675ed
    ];

    protected $enumEducationPrograms = [
        'REGULAR' => 'Regular',
        'EXTENTION' => 'Extension',
        'SUMMER' => 'Summer',
        'DISTANCE' => 'Distance',
<<<<<<< HEAD
        'NONE' => 'None'
=======
        'NONE'=>'none'
>>>>>>> e53315c6c8e631881469ae3b8ebeac0ff58675ed
    ];

    public function technicalStaffs()
    {
        return $this->hasMany('App\Models\College\TechnicalStaff');
    }

    public function collegeName(){
        return $this->belongsTo('App\Models\College\CollegeName');
    }

    public function departments(){
        return $this->hasMany('App\Models\Department\Department');
    }

    public function band()
    {
        return $this->belongsTo('App\Models\Band\Band');
    }
}
