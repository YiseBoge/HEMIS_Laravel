<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class RegionName extends Model
{
    use Uuids;

    public $incrementing = false;

    public function specialRegionEnrollment()
    {
        return $this->hasMany('App\Models\Department\SpecialRegionEnrollment');
    }
}


