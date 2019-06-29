<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null building_name
 * @property string|null contractor_name
 * @property string|null consultant_name
 * @property DateTime date_started
 * @property DateTime date_completed
 * @property int budget_allocated
 * @property int financial_status
 * @property int completion_status
 * @property Uuid college_id
 */
class Building extends Model
{
    use Uuids;

    public $incrementing = false;

    /**
     * @return BelongsTo
     */
    public function college()
    {
        return $this->belongsTo('App\Models\College\College');
    }

    /**
     * @return BelongsToMany
     */
    public function buildingPurposes()
    {
        return $this->belongsToMany('App\Models\Institution\BuildingPurpose', 'building_building_purpose', 'building_id', 'building_purpose_id');
    }

    /**
     * @return string|null
     */
    public function __toString()
    {
        return $this->building_name;
    }
}
