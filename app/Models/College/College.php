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
        'NONE' => 'None'
    ];

    protected $enumEducationPrograms = [
        'REGULAR' => 'Regular',
        'EXTENTION' => 'Extension',
        'SUMMER' => 'Summer',
        'DISTANCE' => 'Distance',
        'NONE' => 'None'
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

    public function budgets()
    {
        return $this->hasMany('App\Models\College\Budget');
    }

    public function internalRevenues()
    {
        return $this->hasMany('App\Models\College\InternalRevenue');
    }

    public function investments()
    {
        return $this->hasMany('App\Models\College\Investment');
    }

    public function ictStaff()
    {
        return $this->hasMany('App\Models\Staff\IctStaff');
    }

    public function technicalStaff()
    {
        return $this->hasMany('App\Models\Staff\TechnicalStaff');
    }

    public function managementStaffs()
    {
        return $this->hasMany('App\Models\Staff\ManagementStaff');
    }

    public function band()
    {
        return $this->belongsTo('App\Models\Band\Band');
    }

    public function universityIndustryLinkages()
    {
        return $this->hasMany('App\Models\Band\UniversityIndustryLinkage');
    }

}
