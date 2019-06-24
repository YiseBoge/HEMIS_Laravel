<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use Uuids;

    public $incrementing = false;

    public function college()
    {
        return $this->belongsTo('App\Models\College\College');
    }

    public function buildingPurposes()
    {
        return $this->belongsToMany('App\Models\Institution\BuildingPurpose', 'building_building_purpose', 'building_id', 'building_purpose_id');
    }

    public function __toString()
    {
        return $this->building_name;
    }
}
