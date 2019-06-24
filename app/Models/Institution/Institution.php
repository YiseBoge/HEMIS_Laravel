<?php

namespace App\Models\Institution;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    protected $enumApprovalTypes = [
        'APPROVED' => 'Approved',
        'PENDING' => 'Pending',
        'DISAPPROVED' => 'Disapproved'
    ];

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

    public function foreignStaff()
    {
        return $this->hasMany('App\Models\Institution\ForeignStaff');
    }

    public function managements()
    {
        return $this->hasMany('App\Models\Institution\Management');
    }

    public function specialNeeds()
    {
        return $this->hasMany('App\Models\Institution\SpecialNeeds');
    }

    public function InstitutionBSC()
    {
        return $this->hasMany('App\Models\Institution\InstitutionBSC');
    }

    public function __toString()
    {
        return $this->institutionName->__toString() . ' (' . $this->instance->__toString() . ')';
    }
}
