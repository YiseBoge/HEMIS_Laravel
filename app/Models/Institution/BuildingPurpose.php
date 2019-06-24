<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class BuildingPurpose extends Model
{
    use Uuids;

    public $incrementing = false;

    public function buildings()
    {
        return $this->belongsToMany('App\Models\Institution\Building', 'building_building_purpose', 'building_purpose_id', 'building_id');
    }

    public function __toString()
    {
        return $this->purpose;
    }
}
