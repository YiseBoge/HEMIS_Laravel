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


    // Enums //

    public function bandName()
    {
        return $this->belongsTo('App\Models\Band\BandName');
    }

    public function colleges()
    {
        return $this->hasMany('App\Models\College\College');
    }

    public function researches()
    {
        return $this->hasMany('App\Models\Band\Research');
    }

    public function universityIndustryLinkages()
    {
        return $this->hasMany('App\Models\Band\UniversityIndustryLinkage');
    }

    public function technicalStaffs()
    {
        return $this->hasMany('App\Models\College\TechnicalStaff');
    }
}
