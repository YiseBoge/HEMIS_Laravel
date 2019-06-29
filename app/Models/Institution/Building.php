<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null building_name
 * @property array|string|null contractor_name
 * @property array|string|null consultant_name
 * @property array|string|null date_started
 * @property array|string|null date_completed
 * @property array|string|null budget_allocated
 * @property array|string|null financial_status
 * @property array|string|null completion_status
 * @property mixed college_id
 */
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
