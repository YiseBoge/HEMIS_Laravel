<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class BuildingPurpose extends Model
{
    use Uuids;

    public $incrementing = false;

    public function buildings() {
        return $this->belongsToMany(Building::class, 'building_building_purpose');
    }

    public function __toString()
    {
        return $this->purpose;
    }
}
