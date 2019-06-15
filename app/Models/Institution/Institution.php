<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use Uuids;

    public $incrementing = false;

    public function institutionName()
    {
        return $this->belongsTo('App\Models\Institution\InstitutionName');
    }

    public function generalInformation()
    {
        return $this->belongsTo('App\Models\Institution\GeneralInformation');
    }

    public function instance()
    {
        return $this->belongsTo('App\Models\Institution\Instance');
    }

    public function bands()
    {
        return $this->hasMany('App\Models\Band\Band');
    }

    public function adminAndNonAcademicStaff()
    {
        return $this->hasMany('App\Models\Institution\AdminAndNonAcademicStaff');
    }

    public function ageEnrollment()
    {
        return $this->hasMany('App\Models\Institution\AgeEnrollment');
    }

    public function buildings()
    {
        return $this->hasMany('App\Models\Institution\Building');
    }

    public function emergingRegion(){
        return $this->hasMany('App\Models\Institution\EmergingRegion');
    }

    public function foreignStaff(){
        return $this->hasMany('App\Models\Institution\ForeignStaff');
    }

    public function managements()
    {
        return $this->hasMany('App\Models\Institution\Management');
    }

    public function pastoralRegion(){
        return $this->hasMany('App\Models\Institution\PastoralRegion');
    }

    public function specialNeeds(){
        return $this->hasMany('App\Models\Institution\SpecialNeeds');
    }

    public function InstitutionBSC(){
        return $this->hasMany('App\Models\Institution\InstitutionBSC');
    }

    public function __toString()
    {
        return $this->institutionName->__toString() . ' (' . $this->instance->__toString() . ')';
    }
}
