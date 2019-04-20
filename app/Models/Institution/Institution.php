<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use Uuids;

    public $incrementing = false;

    public function institutionName(){
        return $this->hasOne('App\Models\Institution\InstitutionName');
    }

    public function generalInformation(){
        return $this->hasOne('App\Models\Institution\GeneralInformation');
    }

    public function instance(){
        return $this->belongsTo('App\Models\Institution\Instance');
    }


    public function budgets(){
        return $this->hasMany('App\Models\Institution\Budget');
    }

    public function internalRevenues(){
        return $this->hasMany('App\Models\Institution\InternalRevenue');
    }

    public function privateInvestments(){
        return $this->hasMany('App\Models\Institution\Investment');
    }


    public function bands(){
        return $this->hasMany('App\Models\Band\Band');
    }


    public function academicStaff(){
        return $this->hasMany('App\Models\Staff\Specializations\AcademicStaff');
    }

    public function administrativeStaff(){
        return $this->hasMany('App\Models\Staff\Specializations\AdministrativeStaff');
    }

    public function technicalStaff(){
        return $this->hasMany('App\Models\Staff\Specializations\TechnicalStaff');
    }

    public function ictStaff(){
        return $this->hasMany('App\Models\Staff\Specializations\IctStaff');
    }

    public function supportiveStaff(){
        return $this->hasMany('App\Models\Staff\Specializations\SupportiveStaff');
    }


    public function staffAttrition(){
        return $this->hasMany('App\Models\Institution\StaffAttrition');
    }
}
