<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class SpecialRegionEnrollment extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumRegionTypes = [
        'EMERGING_REGIONS' => 'Emerging Regions',
        'PASTORAL_REGIONS' => 'Pastoral Regions'
    ];

    public function regionName()
    {
        return $this->belongsTo('App\Models\Institution\RegionName');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }
}
