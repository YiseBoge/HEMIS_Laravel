<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static SpecialRegionEnrollment find(int $id)
 */
class SpecialRegionEnrollment extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumRegionTypes = [
        'EMERGING_REGIONS' => 'Emerging Regions',
        'PASTORAL_REGIONS' => 'Pastoral Regions'
    ];

    /**
     * @return BelongsTo
     */
    public function regionName()
    {
        return $this->belongsTo('App\Models\Institution\RegionName');
    }

    /**
     * @return BelongsTo
     */
    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }

    /**
     * @return bool
     */
    public function isDuplicate()
    {
        return SpecialRegionEnrollment::where(array(
                'department_id' => $this->department_id,
                'region_name_id' => $this->region_name_id,
            ))->first() != null;
    }
}
